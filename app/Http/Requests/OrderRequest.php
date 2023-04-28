<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'confirmed' => 'required|boolean',
            'delivered' => 'required|boolean',
            'client_id' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'confirmed.required' => 'Confirmed is required',
            'delivered.required' => 'Delivered is required',
            'client_id.required' => 'A client_id is required',
            'client_id.integer' => 'A client_id should be an integer',

        ];
    }
}
