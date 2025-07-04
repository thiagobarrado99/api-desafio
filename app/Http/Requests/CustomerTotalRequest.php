<?php

namespace App\Http\Requests;

class CustomerTotalRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'month' => ['required', 'string', 'regex:/^\d{4}-\d{2}$/'],
            'id' => ['required', 'exists:customers,id'],
        ];
    }
}
