<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use App\Models\OrderProducts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderListController extends Controller
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
        $this->authorize('add Order_List');
        $OrderList = OrderList::query()->create([
            'customer_id' => Auth::id(),
            'order_quantity'=>0,
            'order_cost' => 0.0,
            'ordered'=> 0,
        ]);
        return response()->json([
            'data'=>$OrderList,
            'status code'=>201
        ]);
    }

    // $ExpertID = Auth::id();
    //     $appointmentID= $request->input('appointment_id');
    //     $done  =$request->input('done');
    //     $check = Appointment::where('id',$appointmentID);
    //     $checkExpertId = $check->value('expert_id');
    //     if ($checkExpertId == $ExpertID){
    //         $checkApprovement = $check->value('approve');
    //         if ($checkApprovement == 1)
    //         {
    //             $updated = Appointment::find($appointmentID)->update(['done'=>$done]);
    //         return response()->json(['message'=>'DONE'], 200);
    //         }
    //         else{
    //             return response()->json(['message'=>'you can not access to this service'], 203);
    //         }
    //     }
    //     else{
    //         return response()->json(['message'=>'you can not access to this service'], 203);
    //     }

    public function ordering(Request $request)
    {
        $OrderList_id = $request->OrderList_id;
        $ordered = $request->ordered;
        $updtaing = OrderList::query()->find($OrderList_id)->update(['ordered'=> $ordered]);
        return response()->json(['data'=>$updtaing,'status code'=>200]);
    }

    public function dropOrder(Request $request)
    {
        

    }

    /**
     * Display the specified resource.
     */
    public function showOrderLists($id)
    {
        $orders = Order::where('shipment_id',$id)->get();
        foreach ($orders as $order ) {
            $orderLists = OrderList::where('id',$order->OrderList_id)->with('customers')->get();
            $data [] = 
            [
                $order,
                $orderLists
            ];
            $allOrders[]= $data;
        }
        if ($orders->isNotEmpty()) {
            return response()->json(
                $allOrders
            ,200);
        } else {
            return response()->json([
                'message' => 'no orders to show'
            ]);
        }
            
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderList $orderList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderList $orderList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderList $orderList)
    {
        //
    }
}
