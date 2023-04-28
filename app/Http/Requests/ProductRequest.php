<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer',
            'rate' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'description.required' => 'A description is required',
            'price.required' => 'A price is required',
            'price.decimal' => 'A price should be a float',
            'stock.required' => 'A stock is required',
            'stock.integer' => 'A stock should be an integer',
            'rate.required' => 'A rate is required',
            'rate.decimal' => 'A rate hould be a float',
        ];
    }
}
