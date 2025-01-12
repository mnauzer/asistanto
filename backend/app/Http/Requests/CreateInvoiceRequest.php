<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization will be handled by middleware
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'due_date' => 'required|date|after:today',
            'payment_terms' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            // Optional payment details if paying immediately
            'payment_method' => 'nullable|required_with:payment_reference|string|in:cash,card,bank_transfer',
            'payment_reference' => 'nullable|string|max:255',
            'payment_date' => 'nullable|required_with:payment_method|date',
            // Allow custom billing address different from order
            'billing_address' => 'nullable|array',
            'billing_address.street' => 'required_with:billing_address|string|max:255',
            'billing_address.city' => 'required_with:billing_address|string|max:100',
            'billing_address.state' => 'required_with:billing_address|string|max:100',
            'billing_address.postal_code' => 'required_with:billing_address|string|max:20',
            'billing_address.country' => 'required_with:billing_address|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => 'An order must be selected.',
            'order_id.exists' => 'The selected order is invalid.',
            'due_date.required' => 'Due date is required.',
            'due_date.after' => 'Due date must be after today.',
            'payment_method.required_with' => 'Payment method is required when providing payment reference.',
            'payment_method.in' => 'Invalid payment method selected.',
            'payment_reference.max' => 'Payment reference cannot exceed 255 characters.',
            'payment_date.required_with' => 'Payment date is required when providing payment method.',
            'billing_address.street.required_with' => 'Billing street address is required when providing billing address.',
            'billing_address.city.required_with' => 'Billing city is required when providing billing address.',
            'billing_address.state.required_with' => 'Billing state is required when providing billing address.',
            'billing_address.postal_code.required_with' => 'Billing postal code is required when providing billing address.',
            'billing_address.country.required_with' => 'Billing country is required when providing billing address.',
        ];
    }

    protected function prepareForValidation()
    {
        // If payment is marked as received, ensure payment date is set
        if ($this->input('payment_received') && !$this->input('payment_date')) {
            $this->merge([
                'payment_date' => now()->toDateString()
            ]);
        }
    }
}
