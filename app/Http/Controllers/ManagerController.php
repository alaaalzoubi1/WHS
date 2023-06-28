<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{

    public function LogIn (Request $request)
    {
        $LogInData = $request-> validate([
            'id' =>'required|exists:managers',
            'password'=>'required',
        ]);

        if(auth()->guard('manager')->attempt(['id' => request('id'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'manager']);
            
            $manager = Manager::select('managers.*')->find(auth()->guard('manager')->user()->id);
            $success =  $manager;
            $success['token'] =  $manager->createToken('MyApp',['manager'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => 'id and Password are Wrong.'], 400 );
        }

        if(!auth()->attempt($LogInData))
        {
            return response()->json(['errors'=>
                ['message'=>
                ['could not log in with those data']
                ]
            ],422);
        }
        $manager = $request->user();
        $accessToken = $manager->createToken('personal access token');
        $manager ['remember_token'] = $accessToken;

        return response()->json([
            'data' => $manager,
            'typeToken' => 'Bearer',
            'token' => $accessToken->accessToken
        ], 200);
    }

    public function LogOut ()
    {
        $manager = Auth::manager()->token()->delete();
        return response()->json(['success'=>'logged out successfully'], 200);
    }

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Manager $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manager $manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manager $manager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manager $manager)
    {
        //
    }
}
