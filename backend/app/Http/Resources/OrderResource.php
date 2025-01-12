<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'customer' => new PersonResource($this->customer),
            'items' => $this->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'inventory_item' => [
                        'id' => $item->inventory_item->id,
                        'name' => $item->inventory_item->name,
                        'sku' => $item->inventory_item->sku,
                    ],
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total' => $item->total,
                ];
            }),
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'total' => $this->total,
            'status' => $this->status,
            'notes' => $this->notes,
            'shipping_address' => [
                'street' => $this->shipping_street,
                'city' => $this->shipping_city,
                'state' => $this->shipping_state,
                'postal_code' => $this->shipping_postal_code,
                'country' => $this->shipping_country,
            ],
            'billing_address' => [
                'street' => $this->billing_street,
                'city' => $this->billing_city,
                'state' => $this->billing_state,
                'postal_code' => $this->billing_postal_code,
                'country' => $this->billing_country,
            ],
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'invoice' => $this->invoice ? new InvoiceResource($this->invoice) : null,
        ];
    }
}
