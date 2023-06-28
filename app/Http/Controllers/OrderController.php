<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\OrderList;
use App\Models\Shipment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('add Order');

        $OrderList_id = $request->OrderList_id;
        $shipment_id = $request->shipment_id;

        $OrderList = OrderList::where('id', $OrderList_id);
        $shipment = Shipment::where('id', $shipment_id);

        $order = order::query()->create([
            'OrderList_id'=>$OrderList_id,
            'shipment_id'=>$shipment_id,
            'ready'=>0,
            'arrived'=>0,
        ]);

        $OrderQuantity = $OrderList->value('order_quantity');
        $shipmentQuantity = $shipment->value('shipment_quantity');
        $max_quantity = $shipment->value('max_quantity');
        $totalQuantity = $OrderQuantity + $shipmentQuantity;
        if($totalQuantity <= $max_quantity)
        {
            $updatingQuantity = $shipment->update(['shipment_quantity'=>$totalQuantity]);
            $New_shipmentQuantity = $shipment->first('shipment_quantity');

            $OrderCost =$OrderList->value('order_cost');
            $shipment_cost = $shipment ->value('shipment_cost');
            $newShipmentCost = $OrderCost + $shipment_cost;
            $ShipCoUpdate = $shipment->update(['shipment_cost'=>$newShipmentCost]);
            $New_shipmentCost = $shipment->first('shipment_cost');

            return response()->json([
                'data'=>[$order,$New_shipmentCost, $New_shipmentQuantity],
                'status code'=>201
            ]);
        }
        else
        {
            return response()->json([
                'message'=>'please change the shipment',
                'status code'=> 400
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }
}
