<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ShowBranches()
    {
        $branches = Branch::query()->get();
        
        return response()->json([
            'data'=>$branches,
            'status code'=> http_response_code(),
        ]);
    }

    public function BranchDetails(Request $request)
    {
        $branch_id = $request->input('branch_id');
        $branch_data = Branch::query()->where('id', $branch_id)->get();
        
        return response()->json([
            'data'=>$branch_data,
            'status code'=> http_response_code(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this-> validate($request, [
            'phone_number'=>'required',
            'space'=>'required',
            'company_register' => 'required ',
        ]);
            
            $branch = Branch::query()->create([
                'address_id'=>$request->address_id,
                'phone_number'=>$request->phone_number,
                'space'=>$request->space,
                'company_register' => $request->company_register,
                'sectionMaxCapacity'=> $request->section_maxCapacity,
            ]);
            return response()->json([
                'data'=>$branch,
                'status code'=> http_response_code(),
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(branch $branch)
    {
        //
    }
}
