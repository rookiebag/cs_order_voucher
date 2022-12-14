<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\OrderItems;
use App\Http\Requests\OrderPostRequest;
use App\Http\Resources\OrderResource;
class Orders extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('created_at')->paginate(1);
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderPostRequest $request)
    {        
        $validated = $request->validated();
        $orderId = 0;
        $qtyTotal = $subTotal = $discountValue = 0;
        $voucher = null;
        
        $orderItems = [];
        foreach ($validated['items'] as $item) {
            $qtyTotal += $item['qty'];
            $subTotal += ($item['qty'] * $item['price']);

            $orderItem = [];
            $orderItem['quantity'] = $item['qty'];
            $orderItem['item_name'] = $item['name'];
            $orderItem['item_price'] = $item['price'];
            $orderItem['order_id'] = &$orderId;
            $orderItems[] = $orderItem;
        }

        if ($validated['voucher_code']) 
        {
            $voucher = Voucher::select('vouchers.*')->active()->firstWhere('code', $validated['voucher_code']);            
            if(!$voucher){
                return response()->json([
                    'message' => "Voucher can not be applied!",
                ], 422);
            }
            if ( $voucher->type == Voucher::$value_type ) {
                $discountValue = $voucher->discount_value;
            } else if ( $voucher->type == Voucher::$percentage_type ) {
                $discountValue = $voucher->discount_value * .01 * $subTotal;
            }

            if ($discountValue && $discountValue > $subTotal) {
                return response()->json([
                    'message' => "Voucher can not be applied, due to internal issues!",
                ], 422);
            }
        }

        $order = [];
        $order['user_email'] = $validated['user_email'];
        $order['voucher_id'] = $voucher ? $voucher->id : null;
        $order['quantity'] = $qtyTotal;
        $order['discount'] = $discountValue;
        $order['sub_total'] = $subTotal;
        $order['order_total'] = $subTotal - $discountValue;
        $orderEntity = Order::create($order);

        $orderId = $orderEntity->id;

        OrderItems::insert($orderItems);

        return response()->json([
            'message' => "Order created successfully!",
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
