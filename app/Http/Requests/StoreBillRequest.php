<?php

namespace App\Http\Requests;

class StoreBillRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'amount' => ['required', 'numeric', 'min:0.01', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
            'description' => ['string', 'max:512'],
        ];
    }
}
