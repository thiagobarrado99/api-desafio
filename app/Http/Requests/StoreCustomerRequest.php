<?php

namespace App\Http\Requests;

class StoreCustomerRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'tax_id' => ['required', 'string', 'max:14', 'regex:/^\d+$/'],
            'email' => ['required', 'email', 'max:256', 'unique:customers,email'],
        ];
    }
}
