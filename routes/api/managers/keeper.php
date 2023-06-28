<?php

use App\Http\Controllers\Approve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchesCustomersController;
use App\Http\Controllers\BranchesInnerCatController;
use App\Http\Controllers\BranchesProductsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentFixController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\InnerCategoryController;
use App\Http\Controllers\ProducingCompanyController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderListController;
use App\Http\Controllers\OrderProductsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\StoringLocationsController;
use App\Models\BranchesCustomers;
use App\Http\Middleware\Admin;
use App\Models\Equipment;
use App\Models\EquipmentFix;
use App\Models\Financial;
Route:: prefix('/keeper')->group( function (){ 
    Route::group( ['middleware' => ['auth:manager-api','scopes:manager'] ],function(){

        Route::post('/update/{requet_id}', [Approve::class, 'updateState']);
        Route::post('/reject/{request_id}', [Approve::class, 'reject']);

        
        Route::group([ 
            'middleware'=>'keeper',], function(){
                Route::post('/Orderd', [OrderListController::class, 'ordering']);
                Route:: prefix('/Add')->group( function (){ 
                    Route::post('/newEquipment', [EquipmentController::class, 'AddNewEquipments']);
                    Route::post('/AddNewProduct',[ProductController::class,'store']);
                    Route::post('/Addcategories',[CategoryController::class, 'AddCat']);
                    Route::post('/keeperAddShipment',[ShipmentController::class, 'keeperAddShipment']);
                    Route::post('/storeProduct',[BranchesProductsController::class, 'storeProduct']);
                });
                Route:: prefix('/show')->group( function (){
                    Route::get('/BranchEmployees/{id}',[EmployeeController::class, 'ShowBranchesEmployee']);
                    Route::get('/BranchManagers/{branch_id}/{role_id}',[EmployeeController::class, 'ShowBranchesAssistants']);
                    Route::get('/EmployeesDetails/{emp_id}',[EmployeeController::class, 'showDetails']);
                    Route::get('showProductDetails/{id}',[ProductController::class,'showProductDetails']);
                    Route::get('showShipments',[ShipmentController::class,'showShipments']);
                    Route::get('ShipmentDetails/{id}',[ShipmentController::class,'ShipmentDetails']);
                    Route::get('showOrderLists/{id}',[OrderListController::class,'showOrderLists']);
                    Route::get('showOrderProducts/{Order_list_id}',[OrderProductsController::class,'showOrderProducts']);
//showDetails
                    });
                Route::prefix('/edit')->group(function(){
                    Route::post('/editProduct/{id}',[BranchesProductsController::class, 'editProduct']);
                });
            }
        );
    });
});
