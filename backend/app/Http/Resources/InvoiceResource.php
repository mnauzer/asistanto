<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'order' => [
                'id' => $this->order->id,
                'order_number' => $this->order->order_number,
            ],
            'customer' => new PersonResource($this->customer),
            'items' => $this->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total' => $item->total,
                ];
            }),
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'total' => $this->total,
            'status' => $this->status,
            'due_date' => $this->due_date->toISOString(),
            'paid_at' => $this->paid_at ? $this->paid_at->toISOString() : null,
            'payment_method' => $this->payment_method,
            'payment_reference' => $this->payment_reference,
            'notes' => $this->notes,
            'billing_address' => [
                'street' => $this->billing_street,
                'city' => $this->billing_city,
                'state' => $this->billing_state,
                'postal_code' => $this->billing_postal_code,
                'country' => $this->billing_country,
            ],
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}
