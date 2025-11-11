<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryLocationUpdated;
use App\Http\Controllers\Controller;
use App\Models\DeliveryOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveriesController extends Controller
{
    //
    public function show($id){
        $deliveryOrder= DeliveryOrder::query()->select([
            'id',
            'order_id',
            'delivery_id',
            'status',
            DB::raw("ST_Y(current_location) AS lat"),
            DB::raw("ST_X(current_location) AS lng"),
            ])
            ->where('id', $id)
            ->firstOrFail();
        return $deliveryOrder;
    }
    public function update(Request $request,DeliveryOrder $deliveryOrder)
    {
         $request->validate([
           'lng'=>['required','numeric'],
           'lat'=>['required','numeric']
         ]);
         $deliveryOrder->update([
            'current_location' => DB::raw("POINT({$request->lng}, {$request->lat})"),
         ]);
         event(new DeliveryLocationUpdated($deliveryOrder, $request->lat, $request->lng));

         return $deliveryOrder;
    }
}
