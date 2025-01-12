<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Cache::remember('orders.customer.' . $request->user()->id, 3600, function () use ($request) {
            return Order::with(['customer', 'items.inventory_item'])
                ->where('customer_id', $request->user()->id)
                ->latest()
                ->paginate(10);
        });

        return OrderResource::collection($orders);
    }

    public function store(CreateOrderRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            // Check inventory availability
            foreach ($validated['items'] as $item) {
                $inventoryItem = InventoryItem::lockForUpdate()->find($item['inventory_item_id']);

                if (!$inventoryItem || $inventoryItem->quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for item: {$inventoryItem->name}");
                }
            }

            // Create order
            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'shipping_street' => $validated['shipping_address']['street'],
                'shipping_city' => $validated['shipping_address']['city'],
                'shipping_state' => $validated['shipping_address']['state'],
                'shipping_postal_code' => $validated['shipping_address']['postal_code'],
                'shipping_country' => $validated['shipping_address']['country'],
                'billing_street' => $validated['billing_address']['street'],
                'billing_city' => $validated['billing_address']['city'],
                'billing_state' => $validated['billing_address']['state'],
                'billing_postal_code' => $validated['billing_address']['postal_code'],
                'billing_country' => $validated['billing_address']['country'],
            ]);

            $subtotal = 0;

            // Create order items and update inventory
            foreach ($validated['items'] as $item) {
                $inventoryItem = InventoryItem::find($item['inventory_item_id']);

                // Deduct from inventory
                $inventoryItem->decrement('quantity', $item['quantity']);

                // Create order item
                $itemTotal = $item['quantity'] * $inventoryItem->price;
                $subtotal += $itemTotal;

                $order->items()->create([
                    'inventory_item_id' => $item['inventory_item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $inventoryItem->price,
                    'total' => $itemTotal,
                ]);
            }

            // Calculate and update totals
            $tax = $subtotal * 0.20; // 20% tax rate

            $order->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $subtotal + $tax,
            ]);

            DB::commit();

            // Clear cache
            Cache::forget('orders.customer.' . $request->user()->id);

            return new OrderResource($order->load(['customer', 'items.inventory_item']));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return new OrderResource($order->load(['customer', 'items.inventory_item', 'invoice']));
    }

    public function update(CreateOrderRequest $request, Order $order)
    {
        $this->authorize('update', $order);

        if ($order->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending orders can be updated.'
            ], 422);
        }

        $validated = $request->validated();

        try {
            DB::beginTransaction();

            // Restore previous inventory quantities
            foreach ($order->items as $item) {
                $item->inventory_item->increment('quantity', $item['quantity']);
            }

            // Check new inventory availability
            foreach ($validated['items'] as $item) {
                $inventoryItem = InventoryItem::lockForUpdate()->find($item['inventory_item_id']);

                if (!$inventoryItem || $inventoryItem->quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for item: {$inventoryItem->name}");
                }
            }

            // Update order details
            $order->update([
                'notes' => $validated['notes'] ?? null,
                'shipping_street' => $validated['shipping_address']['street'],
                'shipping_city' => $validated['shipping_address']['city'],
                'shipping_state' => $validated['shipping_address']['state'],
                'shipping_postal_code' => $validated['shipping_address']['postal_code'],
                'shipping_country' => $validated['shipping_address']['country'],
                'billing_street' => $validated['billing_address']['street'],
                'billing_city' => $validated['billing_address']['city'],
                'billing_state' => $validated['billing_address']['state'],
                'billing_postal_code' => $validated['billing_address']['postal_code'],
                'billing_country' => $validated['billing_address']['country'],
            ]);

            // Delete existing items
            $order->items()->delete();

            $subtotal = 0;

            // Create new order items and update inventory
            foreach ($validated['items'] as $item) {
                $inventoryItem = InventoryItem::find($item['inventory_item_id']);

                // Deduct from inventory
                $inventoryItem->decrement('quantity', $item['quantity']);

                // Create order item
                $itemTotal = $item['quantity'] * $inventoryItem->price;
                $subtotal += $itemTotal;

                $order->items()->create([
                    'inventory_item_id' => $item['inventory_item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $inventoryItem->price,
                    'total' => $itemTotal,
                ]);
            }

            // Recalculate totals
            $tax = $subtotal * 0.20; // 20% tax rate

            $order->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $subtotal + $tax,
            ]);

            DB::commit();

            // Clear cache
            Cache::forget('orders.customer.' . $request->user()->id);

            return new OrderResource($order->load(['customer', 'items.inventory_item']));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        if ($order->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending orders can be deleted.'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Restore inventory quantities
            foreach ($order->items as $item) {
                $item->inventory_item->increment('quantity', $item->quantity);
            }

            $order->delete();

            DB::commit();

            // Clear cache
            Cache::forget('orders.customer.' . auth()->id());

            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $year = date('Y');
        $month = date('m');

        $lastOrder = Order::where('order_number', 'like', "{$prefix}{$year}{$month}%")
            ->orderBy('order_number', 'desc')
            ->first();

        if ($lastOrder) {
            $sequence = (int)substr($lastOrder->order_number, -4);
            $sequence++;
        } else {
            $sequence = 1;
        }

        return sprintf("%s%s%s%04d", $prefix, $year, $month, $sequence);
    }
}
