<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are protected against mass assigning.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Get the items.
     */
    public function items()
    {
        return $this->hasMany('App\Models\OrderItems', 'order_id');
    }
}
