<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Carbon\Carbon;
class Voucher extends Model
{
    use HasFactory;

    /**
     * Voucher Type 
     */
    public static $value_type = 1;
    public static $percentage_type = 2;

    /**
     * The attributes that are protected against mass assigning.
     *
     * @var array<int, string>
     */
    protected $guarded = ['is_valid'];

    /**
     * Get the orders owns the voucher.
     */
    public function getOrders()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeActive($query)
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        return $query->where('is_valid', 1)->whereDate('end_date', '>=', $today)->leftJoin('orders', 'vouchers.id', 'orders.voucher_id')->whereNull('orders.voucher_id');
    }
 
    public function scopeExpired($query)
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        return $query->whereDate('end_date', '<=', $today);
    }

    public function scopeUsed($query)
    {
        return $query->join('orders', 'vouchers.id', 'orders.voucher_id');
    }
}
