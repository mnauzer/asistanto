<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization will be handled by middleware
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:people,id',
            'items' => 'required|array|min:1',
            'items.*.inventory_item_id' => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|array',
            'shipping_address.street' => 'required|string|max:255',
            'shipping_address.city' => 'required|string|max:100',
            'shipping_address.state' => 'required|string|max:100',
            'shipping_address.postal_code' => 'required|string|max:20',
            'shipping_address.country' => 'required|string|max:100',
            'billing_address' => 'required|array',
            'billing_address.street' => 'required|string|max:255',
            'billing_address.city' => 'required|string|max:100',
            'billing_address.state' => 'required|string|max:100',
            'billing_address.postal_code' => 'required|string|max:20',
            'billing_address.country' => 'required|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'A customer must be selected.',
            'customer_id.exists' => 'The selected customer is invalid.',
            'items.required' => 'At least one item is required.',
            'items.*.inventory_item_id.required' => 'Each item must reference an inventory item.',
            'items.*.inventory_item_id.exists' => 'One or more selected items are invalid.',
            'items.*.quantity.required' => 'Each item must have a quantity.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'shipping_address.required' => 'Shipping address is required.',
            'shipping_address.street.required' => 'Shipping street address is required.',
            'shipping_address.city.required' => 'Shipping city is required.',
            'shipping_address.state.required' => 'Shipping state is required.',
            'shipping_address.postal_code.required' => 'Shipping postal code is required.',
            'shipping_address.country.required' => 'Shipping country is required.',
            'billing_address.required' => 'Billing address is required.',
            'billing_address.street.required' => 'Billing street address is required.',
            'billing_address.city.required' => 'Billing city is required.',
            'billing_address.state.required' => 'Billing state is required.',
            'billing_address.postal_code.required' => 'Billing postal code is required.',
            'billing_address.country.required' => 'Billing country is required.',
        ];
    }

    protected function prepareForValidation()
    {
        // If billing address is same as shipping, copy shipping address
        if ($this->input('same_as_shipping')) {
            $this->merge([
                'billing_address' => $this->input('shipping_address')
            ]);
        }
    }
}
