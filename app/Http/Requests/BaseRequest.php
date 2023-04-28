<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    protected function failedValidation($validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, $this->response($validator));
    }

    protected function response($validator)
    {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors(),
        ], 422);
    }
}
