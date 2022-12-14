<?php

namespace App\Http\Resources;

use App\Http\Resources\OrderItemsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_email' => $this->user_email,
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'sub_total' => $this->sub_total,
            'order_total' => $this->order_total,
            'purchase_date' => $this->created_at,
            'items' => OrderItemsResource::collection($this->items)
        ];
    }
}
