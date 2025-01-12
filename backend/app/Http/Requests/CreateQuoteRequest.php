<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteRequest extends FormRequest
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
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'valid_until' => 'required|date|after:today',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => 'A customer must be selected.',
            'customer_id.exists' => 'The selected customer is invalid.',
            'items.required' => 'At least one item is required.',
            'items.*.description.required' => 'Each item must have a description.',
            'items.*.quantity.required' => 'Each item must have a quantity.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'items.*.unit_price.required' => 'Each item must have a unit price.',
            'items.*.unit_price.min' => 'Unit price cannot be negative.',
            'valid_until.required' => 'The validity date is required.',
            'valid_until.after' => 'The validity date must be after today.',
        ];
    }
}
