<?php

namespace App\Rules;
use App\Models\Voucher;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class VoucherValidity implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($voucherEntity, $validate)
    {
        $this->voucher = $voucherEntity;
        $this->validateFor = $validate;
        $this->errorMessage = '';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$this->voucher)
        {
            $this->errorMessage = 'No voucher found!';
            return false;
        }
        if ($this->validateFor == 'used_valid'){
            if (!$this->voucher->is_valid)
            {
                $this->errorMessage = 'Voucher is not valid!';
                return false;
            } else {
                $today = Carbon::now();
                $voucherEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->voucher->end_date);
                $this->errorMessage = 'Voucher is expired!';
                return !$today->lt($voucherEndDate);
            }
            return !$this->voucher->getOrders;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMessage;
    }
}
