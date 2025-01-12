<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Cache::remember('invoices.customer.' . $request->user()->id, 3600, function () use ($request) {
            return Invoice::with(['customer', 'order', 'items'])
                ->where('customer_id', $request->user()->id)
                ->latest()
                ->paginate(10);
        });

        return InvoiceResource::collection($invoices);
    }

    public function store(CreateInvoiceRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $order = Order::findOrFail($validated['order_id']);

            // Check if invoice already exists
            if ($order->invoice()->exists()) {
                throw new \Exception('Invoice already exists for this order.');
            }

            // Create invoice
            $invoice = Invoice::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'due_date' => $validated['due_date'],
                'payment_terms' => $validated['payment_terms'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
                'subtotal' => $order->subtotal,
                'tax' => $order->tax,
                'total' => $order->total,
                // Use custom billing address if provided, otherwise use order's billing address
                'billing_street' => $validated['billing_address']['street'] ?? $order->billing_street,
                'billing_city' => $validated['billing_address']['city'] ?? $order->billing_city,
                'billing_state' => $validated['billing_address']['state'] ?? $order->billing_state,
                'billing_postal_code' => $validated['billing_address']['postal_code'] ?? $order->billing_postal_code,
                'billing_country' => $validated['billing_address']['country'] ?? $order->billing_country,
            ]);

            // Copy order items to invoice items
            foreach ($order->items as $orderItem) {
                $invoice->items()->create([
                    'description' => $orderItem->inventory_item->name,
                    'quantity' => $orderItem->quantity,
                    'unit_price' => $orderItem->unit_price,
                    'total' => $orderItem->total,
                ]);
            }

            // Handle immediate payment if provided
            if (isset($validated['payment_method'])) {
                $invoice->update([
                    'status' => 'paid',
                    'payment_method' => $validated['payment_method'],
                    'payment_reference' => $validated['payment_reference'] ?? null,
                    'paid_at' => $validated['payment_date'] ?? now(),
                ]);

                // Update order status
                $order->update(['status' => 'completed']);
            }

            DB::commit();

            // Clear cache
            Cache::forget('invoices.customer.' . $request->user()->id);
            Cache::forget('orders.customer.' . $request->user()->id);

            return new InvoiceResource($invoice->load(['customer', 'order', 'items']));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        return new InvoiceResource($invoice->load(['customer', 'order', 'items']));
    }

    public function downloadPdf(Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        $pdf = PDF::loadView('invoices.pdf', [
            'invoice' => $invoice->load(['customer', 'order', 'items'])
        ]);

        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }

    public function markAsPaid(Invoice $invoice, Request $request)
    {
        $this->authorize('update', $invoice);

        $request->validate([
            'payment_method' => 'required|string|in:cash,card,bank_transfer',
            'payment_reference' => 'nullable|string|max:255',
            'payment_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $invoice->update([
                'status' => 'paid',
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->payment_reference,
                'paid_at' => $request->payment_date ?? now(),
            ]);

            // Update order status
            $invoice->order->update(['status' => 'completed']);

            DB::commit();

            // Clear cache
            Cache::forget('invoices.customer.' . auth()->id());
            Cache::forget('orders.customer.' . auth()->id());

            return new InvoiceResource($invoice->load(['customer', 'order', 'items']));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $year = date('Y');
        $month = date('m');

        $lastInvoice = Invoice::where('invoice_number', 'like', "{$prefix}{$year}{$month}%")
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            $sequence = (int)substr($lastInvoice->invoice_number, -4);
            $sequence++;
        } else {
            $sequence = 1;
        }

        return sprintf("%s%s%s%04d", $prefix, $year, $month, $sequence);
    }
}
