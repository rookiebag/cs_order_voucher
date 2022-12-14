<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Voucher;
use App\Rules\VoucherTypeRule;
use App\Rules\VoucherValidity;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VoucherEditRequest extends FormRequest
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
        $voucherCode = $this->code;
        $voucher = Voucher::firstWhere('code', $voucherCode);
        return [
            'name' => 'required|max:100',
            'code' => ['required', 'max:50', Rule::unique('vouchers')->ignore($voucher), new VoucherValidity($voucher, 'used_valid')],
            'type' => ['required', new VoucherTypeRule],
            'discount_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
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
