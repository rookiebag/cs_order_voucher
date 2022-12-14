<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\VoucherResource;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Requests\VoucherPostRequest;
use App\Http\Requests\VoucherEditRequest;

class Vouchers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vouchers = Voucher::paginate(4);
        return VoucherResource::collection($vouchers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VoucherPostRequest $request)
    {
        $validated = $request->validated();

        $voucher = Voucher::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'type' => $validated['type'],
            'discount_value' => $validated['discount_value'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return $voucher;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        return new VoucherResource($voucher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VoucherEditRequest $request, $id)
    {
        $validated = $request->validated();
        $voucher = Voucher::find($id);
        $voucher->name = $validated['name'];
        $voucher->code = $validated['code'];
        $voucher->type = $validated['type'];
        $voucher->discount_value = $validated['discount_value'];
        $voucher->start_date = $validated['start_date'];
        $voucher->end_date = $validated['end_date'];
        $voucher->save();
        
        return response()->json([
            'message' => 'Voucher Updated Successfully!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        
        if(!$voucher){
            return response()->json([
                'message' => 'Voucher not found!',
            ], 401);
        }
        if (!$voucher->is_valid)
        {
            return response()->json([
                'message' => 'Voucher is not valid!',
            ], 204);

        } else {
            $today = Carbon::now();
            $voucherEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $voucher->end_date);
            if ($voucherEndDate->lt($today))
            {
                return response()->json([
                    'message' => 'Voucher is expired!',
                ], 204);
            } else {
                $voucher->delete();
                return response()->json([
                    'message' => 'Voucher is deleted succesfully!',
                ], 201);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activeVouchers()
    {
        $vouchers = Voucher::select(['vouchers.*'])->active()->orderBy('start_date')->get();
        return VoucherResource::collection($vouchers);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expiredVouchers()
    {
        $vouchers = Voucher::expired()->orderBy('start_date')->get();
        return VoucherResource::collection($vouchers);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function usedVouchers()
    {
        $vouchers = Voucher::used()->orderBy('start_date')->get();
        return VoucherResource::collection($vouchers);
    }
}
