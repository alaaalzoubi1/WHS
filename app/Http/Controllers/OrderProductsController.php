<?php

namespace App\Http\Controllers;

use App\Models\BranchesProducts;
use App\Models\OrderList;
use App\Models\OrderProducts;
use Illuminate\Http\Request;

class OrderProductsController extends Controller
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
        $this->authorize('add Order_Product');
        
        $BranchProduct_id = $request->BranchProduct_id;
        $quantity = $request->quantity;
        $OrderList_id = $request->OrderList_id;

        $Product = BranchesProducts::where('id', $BranchProduct_id);
        $OrderList = OrderList::where('id', $OrderList_id);

        $ProductQuantity = $Product->value('quantity');
        $IfOrdered = $OrderList->value('ordered');
        if($IfOrdered == 0 && $ProductQuantity >= $quantity )
        {
            $ProductPrice = $Product->value('price');
            $TotalPrice = $ProductPrice*$quantity;

            $OrderProducts = OrderProducts::query()->create([
                'BranchesProducts_id' => $BranchProduct_id,
                'quantity'=> $quantity,
                'total_price'=>$TotalPrice,
                'OrderList_id'=>$OrderList_id,
            ]);

            $order_cost = $OrderList->value('order_cost');
            $newOrderCost = $order_cost + $TotalPrice;
            $updateCost = $OrderList->update(['order_cost'=>$newOrderCost]); 
            $New_OrderCost = $OrderList->first('order_cost');

            $newProductQuantity = $ProductQuantity - $quantity;
            $updatequantity = $Product->update(['quantity'=>$newProductQuantity]); 
            $New_ProductQuantity = $Product->first('quantity');

            $OrderQuantity = $OrderList->value('order_quantity');
            $TotalQuantity = $OrderQuantity + $quantity;
            $updateOrderQuantity = $OrderList->update(['order_quantity'=>$TotalQuantity]);
            $New_OrderQuantity = $OrderList->first('order_quantity');
        
            return response()->json([
                'data'=>[$OrderProducts, $New_OrderCost, $New_ProductQuantity, $New_OrderQuantity],
                'status code'=>201
            ]);
            
        }
        else
        {
            return response()->json([
                'message'=>'you can not add products to this order',
                'status cade' => 400,
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function showOrderProducts($Order_list_id)
    {
        $products = OrderProducts::where('OrderList_id',$Order_list_id)->get();
        if ($products->isNotEmpty()) {
            return response()->json([
                $products
            ],200);
        }
        else{
            return response()->json([
                'message' => 'no products to show'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderProducts $orderProducts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderProducts $orderProducts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProducts $orderProducts)
    {
        //
    }
}
