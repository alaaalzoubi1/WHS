<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
//use Illuminate\Support\Carbon;
use App\Models\ShipmentKeeper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShipmentController extends Controller
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
        $request->shipment_date;
        $shipment_date = Carbon::createFromFormat('Y-m-d', $request->shipment_date);
        $current_time = Carbon::now();
        $compare = $shipment_date->gt($current_time);

        if($compare == true)
        {
            $shipment = Shipment::query()->create([
                'I\O' => $request->INorOut,
                'SourceAddress_id'=> $request->SourceAddress_id,
                'shipping_company'=> $request->shipping_company,
                'DestinationAddress_id'=> $request->DestinationAddress_id,
                'shipment_date'=>$shipment_date,
                // 'shipment_date'=>$request->shipment_date,
                'shipment_type'=>$request->shipment_type,
                'max_quantity'=>$request->max_quantity,
                'shipment_quantity'=> 0,
                'shipment_cost'=>0.0,
                'shipProducts_cost'=>0.0,
                'arrived'=>0,
            ]);
    
            return response()->json([
                'data'=>$shipment,
                'status code'=>201
            ]);
        }
        else
        {
            return response()->json([
                'message'=>'please change the shipment date',
                'status code'=> 400
            ]);
        }
    }
    public function keeperAddShipment(Request $request)
    {
        $request->shipment_date;
        $shipment_date = Carbon::createFromFormat('Y-m-d', $request->shipment_date);
        $current_time = Carbon::now();
        $compare = $shipment_date->gt($current_time);

        if($compare == true)
        {
            $shipment = ShipmentKeeper::query()->create([
                'I\O' => $request->INorOut,
                'SourceAddress_id'=> $request->SourceAddress_id,
                'shipping_company'=> $request->shipping_company,
                'DestinationAddress_id'=> $request->DestinationAddress_id,
                'shipment_date'=>$shipment_date,
                // 'shipment_date'=>$request->shipment_date,
                'shipment_type'=>$request->shipment_type,
                'max_quantity'=>$request->max_quantity,
                'shipment_quantity'=> 0,
                'shipment_cost'=>0.0,
                'shipProducts_cost'=>0.0,
                'arrived'=>0,
            ]);
    
            return response()->json([
                'data'=>$shipment,
                'status code'=>201
            ]);
        }
        else
        {
            return response()->json([
                'message'=>'please change the shipment date',
                'status code'=> 400
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function showShipments()
    {
        $shipments = Shipment::with('SourceAddresses.regions.cities.countries','DestinationAddresses.regions.cities.countries')->get();
        if($shipments->isNotEmpty()){
        return response()->json([
            $shipments
        ],200);}
        else{
            return response()->json([
                'message' => 'no shipments to show'
            ]);
        }
    }
    public function ShipmentDetails($id)
    {
        $shipment = Shipment::with('SourceAddresses.regions.cities.countries','DestinationAddresses.regions.cities.countries')->where('id', $id)->first();
       
            return response()->json([
                $shipment
            ],200); 
        
        
        
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function editShipment(Request $request, int $id): JsonResponse
{
    $shipment = Shipment::with('SourceAddresses.regions.cities.countries', 'DestinationAddresses.regions.cities.countries')->find($id);

    if (!$shipment) {
        return response()->json([
            'error' => 'Shipment not found'
        ], 404);
    }

    $validatedData = $request->validate([
        'shipment_type' => 'nullable|string',
        'shipping_company' => 'nullable|string',
        'I\\O' => 'nullable',
        'shipment_date' => 'nullable|date',
        'max_quantity' => 'nullable|integer',
        'shipment_quantity' => 'nullable|integer',
        'shipProducts_cost' => 'nullable',
        'shipment_cost' => 'nullable',
        'arrived' => 'nullable|boolean',
        'DestinationAddress_id'=>'nullable',
        'SourceAddress_id' => 'nullable'
    ]);

    $shipment->fill($validatedData);
    $shipment->save();

    return response()->json([
        'message' => 'Shipment updated successfully'
    ]);
}
   // $shipment->shipping_company = $request->shipping_company;
        // $shipment->shipping_company = $request->shipping_company;
        // $shipment->shipping_company = $request->shipping_company;
        // $shipment->shipping_company = $request->shipping_company;
        // $shipment->shipping_company = $request->shipping_company;
        // $shipment->shipping_company = $request->shipping_company;
        // $shipment->shipping_company = $request->shipping_company;
        // $shipment->shipping_company = $request->shipping_company;
        // $shipment->shipping_company = $request->shipping_company;
        // $shipment->shipping_company = $request->shipping_company;
        // $shipment->shipping_company = $request->shipping_company;
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, shipment $shipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(shipment $shipment)
    {
        //
    }
}
