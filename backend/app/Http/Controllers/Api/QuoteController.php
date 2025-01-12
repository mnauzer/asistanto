<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $quotes = Cache::remember('quotes.customer.' . $request->user()->id, 3600, function () use ($request) {
            return Quote::with(['customer', 'items'])
                ->where('customer_id', $request->user()->id)
                ->latest()
                ->paginate(10);
        });

        return QuoteResource::collection($quotes);
    }

    public function store(CreateQuoteRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $quote = Quote::create([
                'customer_id' => $validated['customer_id'],
                'valid_until' => $validated['valid_until'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);

            // Create quote items
            foreach ($validated['items'] as $item) {
                $quote->items()->create([
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            // Calculate and update totals
            $subtotal = $quote->items->sum('total');
            $tax = $subtotal * 0.20; // 20% tax rate

            $quote->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $subtotal + $tax,
            ]);

            DB::commit();

            // Clear cache
            Cache::forget('quotes.customer.' . $request->user()->id);

            return new QuoteResource($quote->load(['customer', 'items']));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show(Quote $quote)
    {
        $this->authorize('view', $quote);

        return new QuoteResource($quote->load(['customer', 'items']));
    }

    public function update(CreateQuoteRequest $request, Quote $quote)
    {
        $this->authorize('update', $quote);

        if ($quote->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending quotes can be updated.'
            ], 422);
        }

        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $quote->update([
                'valid_until' => $validated['valid_until'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Delete existing items and create new ones
            $quote->items()->delete();

            foreach ($validated['items'] as $item) {
                $quote->items()->create([
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            // Recalculate totals
            $subtotal = $quote->items->sum('total');
            $tax = $subtotal * 0.20; // 20% tax rate

            $quote->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $subtotal + $tax,
            ]);

            DB::commit();

            // Clear cache
            Cache::forget('quotes.customer.' . $request->user()->id);

            return new QuoteResource($quote->load(['customer', 'items']));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(Quote $quote)
    {
        $this->authorize('delete', $quote);

        if ($quote->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending quotes can be deleted.'
            ], 422);
        }

        $quote->delete();

        // Clear cache
        Cache::forget('quotes.customer.' . auth()->id());

        return response()->json(null, 204);
    }
}
