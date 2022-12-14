<?php

namespace App\Http\Resources;
use App\Models\Voucher;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type == Voucher::$value_type ? 'By Value': 'By Percentage',
            'value' => $this->discount_value,
            'is_valid' => $this->is_valid,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ];
    }
}