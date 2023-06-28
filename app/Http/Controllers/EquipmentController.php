<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchesEquipmentAssis;
use App\Models\BranchesEquipments;
use App\Models\Equipment;
use App\Models\EquipmentFix;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function showAllEquipments(Request $request) //default: branch
    {

        $getBy = $request->input('get_by');
        $employee_id = $request->employee_id;
        $date = $request->date_in;
        $branch_id = $request->branch_id;
        $name = $request->name;
        $GetEquipment = Equipment::query();

        if ($getBy == 'branch'){
            $GetEquipment = $GetEquipment->where('branch_id', $branch_id)->get();

            if($GetEquipment->isEmpty()){
                return response()->json([
                    'message'=>'there is no equipments in this branch',
                    'status code'=> http_response_code(),
                ]);
            }
            return response()->json([
                'data'=>$GetEquipment,
                'status code'=> http_response_code(),
            ]);
        }

        if ($getBy == 'employee'){
            $GetEquipment = $GetEquipment->where('employee_id', $employee_id)->get();

            if($GetEquipment->isEmpty()){
                return response()->json([
                    'message'=>'there is no equipments in this branch',
                    'status code'=> http_response_code(),
                ]);
            }
            return response()->json([
                'data'=>$GetEquipment,
                'status code'=> http_response_code(),
            ]);
        }

        if ($getBy == 'date in'){
            $Equipment = $GetEquipment->where('date_in', $date);
            $GetEquipment = $Equipment->get();
            $LotQuantity = $Equipment->sum('quantity');
            $LotCost = $Equipment->sum('cost');

            if($GetEquipment->isEmpty()){
                return response()->json([
                    'message'=>'there is no equipments in this branch',
                    'status code'=> http_response_code(),
                ]);
            }
            return response()->json([
                'Equipments'=>$GetEquipment,
                'total quantities in this lot' => $LotQuantity,
                'total cost for this purchase lot '=> $LotCost,
                'status code'=> http_response_code(),
            ]);
        }

        if ($getBy == 'name'){
            $Equipment = $GetEquipment->where('name', $name);
            $GetEquipment = $Equipment->get();
            $EquipmentQuantity = $Equipment->sum('quantity');

            if($GetEquipment->isEmpty()){
                return response()->json([
                    'message'=>'there is no equipments in this branch',
                    'status code'=> http_response_code(),
                ]);
            }
            return response()->json([
                'Equipments'=>$GetEquipment,
                'total quantities' => $EquipmentQuantity,
                'status code'=> http_response_code(),
            ]);
        }
        
    }

    
    public function showEquipments($branch_id, Request $request)
    {

        $getBy = $request->input('get_by');
        $employee_id = $request->employee_id;
        $date = $request->date_in;
        $name = $request->name;
        $GetEquipment = BranchesEquipments::query()->where('branch_id', $branch_id);

        if ($getBy == 'employee'){
            $GetEquipment = $GetEquipment->where('employee_id', $employee_id)->get();

            if($GetEquipment->isEmpty()){
                return response()->json([
                    'message'=>'there is no equipments in this branch',
                    'status code'=> http_response_code(),
                ]);
            }
            return response()->json([
                'data'=>$GetEquipment,
                'status code'=> http_response_code(),
            ]);
        }

        if ($getBy == 'date in'){
            $Equipment = $GetEquipment->where('date_in', $date);
            $GetEquipment = $Equipment->get();
            $LotQuantity = $Equipment->sum('quantity');
            $LotCost = $Equipment->sum('cost');

            if($GetEquipment->isEmpty()){
                return response()->json([
                    'message'=>'there is no equipments in this branch',
                    'status code'=> http_response_code(),
                ]);
            }
            return response()->json([
                'Equipments'=>$GetEquipment,
                'total quantities in this lot' => $LotQuantity,
                'total cost for this purchase lot '=> $LotCost,
                'status code'=> http_response_code(),
            ]);
        }

        if ($getBy == 'name'){
            $Equipment = Branch::find($branch_id)->equipments()->where('equipment_name', $name);
            $GetEquipment = $Equipment->get();
            $EquipmentQuantity = $Equipment->sum('quantity');

            return response()->json([
                'Equipments'=>$GetEquipment,
                'total quantities' => $EquipmentQuantity,
                'status code'=> http_response_code(),
            ]);
        }

        elseif ($getBy == null ){
            $GetEquipment = $GetEquipment->get();
            if($GetEquipment->isEmpty()){
                return response()->json([
                    'message'=>'there is no equipments in this branch',
                    'status code'=> http_response_code(),
                ]);
            }
            return response()->json([
                'Equipments'=>$GetEquipment,
                'status code'=> http_response_code(),
            ]); 
        }
        
    }

    public function showCosts($branch_id, $fixingCost)
    {
        if ($fixingCost == 'true'){
            $GetCost = Equipment::query()->where('branch_id', $branch_id)->sum('cost');
            $branch = Branch::find($branch_id);
            $GetfixingCost = $branch->equipments_fixing()->sum('fixing_cost');
            return response()->json([
                'total cost is:' => $GetCost,
                'total fixing cost is:' => $GetfixingCost,
                'status code:' =>http_response_code(),
            ]);
        }
        elseif ($fixingCost == 'false') {
            $GetCost = Equipment::query()->where('branch_id', $branch_id)->sum('cost');
            return response()->json([
                'total cost is:' => $GetCost,
                'status code:' =>http_response_code(),
            ]);
        }
    }

    public function showAllCosts( $fixingCost)
    {
        if ($fixingCost == 'true'){
            $GetCost = Equipment::query()->sum('cost');
            $GetfixingCost = EquipmentFix::sum('fixing_cost');
            return response()->json([
                'total cost is:' => $GetCost,
                'total fixing cost is:' => $GetfixingCost,
                'status code:' =>http_response_code(),
            ]);
        }
        elseif ($fixingCost == 'false') {
            $GetCost = Equipment::query()->sum('cost');
            return response()->json([
                'total cost is:' => $GetCost,
                'status code:' =>http_response_code(),
            ]);
        }
    }

    public function AddExistingEquipment(Request $request, $equipment_id)
    {
        $branch_id = $request->branch_id;
        $employee_id = $request->employee_id;
        $quantity = $request->quantity;
        $cost = $request->cost;
        $date_in = $request->date_in;

        $existingEquipment = BranchesEquipments::query()->create([
            'branch_id'=> $branch_id,
            'equipment_id'=>$equipment_id,
            'employee_id'=>$employee_id,
            'quantity'=>$quantity,
            'cost'=>$cost,
            'date_in'=>$date_in,
            'available'=>$quantity,
        ]);
        return $existingEquipment;
    }

    public function AddExistingEquipmentAssis(Request $request, $equipment_id)
    {
        $branch_id = $request->branch_id;
        $employee_id = $request->employee_id;
        $quantity = $request->quantity;
        $cost = $request->cost;
        $date_in = $request->date_in;

        $existingEquipment = BranchesEquipmentAssis::query()->create([
            'branch_id'=> $branch_id,
            'equipment_id'=>$equipment_id,
            'employee_id'=>$employee_id,
            'quantity'=>$quantity,
            'cost'=>$cost,
            'date_in'=>$date_in,
            'available'=>$quantity,
        ]);
        return $existingEquipment;
    }

    public function AddNewEquipments(Request $request)
    {
        $equipment_name = $request->equipment_name;
        $description = $request->description;
        $new_publicEquipment = Equipment::query()->create([
            'equipment_name'=>$equipment_name,
            'description'=>$description,
        ]);
        $equipment_id = $new_publicEquipment->id;
        $new_equipment = (new EquipmentController())->AddExistingEquipment($request, $equipment_id);
        return response()->json([
            'system eqipment data' => $new_publicEquipment,
            'barnch equipment data' => $new_equipment,
            'status code' => http_response_code(),
        ]);
    }

    public function responsible()
    {
        
    }

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        //
    }
}
