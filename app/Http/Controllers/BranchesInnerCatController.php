<?php

namespace App\Http\Controllers;

use App\Models\BranchesInnerCat;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateBranchesInnerCatRequest;

class BranchesInnerCatController extends Controller
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
        $this->authorize('add Branch_InnerCat');
        $Branch_InnerCat = BranchesInnerCat::query()->create([
            'branch_id'=> $request->branch_id,
            'InnerCat_id'=>$request->InnerCat_id,
        ]);

        return response()->json([
            'data'=>$Branch_InnerCat,
            'status code' =>201,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BranchesInnerCat $branchesInnerCat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BranchesInnerCat $branchesInnerCat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchesInnerCatRequest $request, BranchesInnerCat $branchesInnerCat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchesInnerCat $branchesInnerCat)
    {
        //
    }
}
