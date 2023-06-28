<?php

namespace App\Http\Controllers;

use App\Models\BranchesCustomers;
use Illuminate\Http\Request;

class BranchesCustomersController extends Controller
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
        $BrunchesCustomers = BranchesCustomers::query()->create([
            'branch_id' => $request->branch_id,
            'customer_id' => $request->customer_id,
        ]);

        return response()->json([$BrunchesCustomers, 'status code' => 201]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BranchesCustomers $branchesCustomers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BranchesCustomers $branchesCustomers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BranchesCustomers $branchesCustomers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchesCustomers $branchesCustomers)
    {
        //
    }
}
