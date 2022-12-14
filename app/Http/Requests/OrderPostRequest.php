<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_email' => 'required|email|max:100',
            'items' => 'required|array',
            'items.*.name' => 'required|string|max:200',
            'items.*.price' => 'required|numeric|min:1',
            'items.*.qty' => 'required|numeric|min:1',
            'voucher_code' => 'sometimes|required|string|exists:vouchers,code',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.*
    * @return array
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'errors' => $validator->errors(),
                    'status' => false
                ], 
            422)
        );
    }
}
