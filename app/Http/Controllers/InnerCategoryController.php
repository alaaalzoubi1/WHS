<?php

namespace App\Http\Controllers;

use App\Models\InnerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InnerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function ShowInnerCats(Request $request)
    {
        $id = $request->id;
        $innerCategories = DB::table('inner_categories')->where('ParentCategory_id','like',$id)->get();
        if ($innerCategories->isEmpty()) {
            return response()->json([
                'message' => 'no inner Categories to show',
                'status code' => 204,
            ]);
        }
        return response()->json([
            'data'=>$innerCategories,
            'status code'=>200,
        ]);
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
        
        $InnerCategory = InnerCategory::query()->create([
            'ParentCategory_id'=>$request->input('parent_category_id'),
            'inner_category' => $request->input('inner_category'),
        ]);
        return response()->json([$InnerCategory], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(innercategory $inner_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(innercategory $inner_category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, innercategory $inner_category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(innercategory $inner_category)
    {
        //
    }
}
