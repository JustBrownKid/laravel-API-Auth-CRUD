<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\CusOderController;


Route::get('/', function () {   
    return response('welcome From APi');
});

Route::get('/items', [ItemController::class ,'index']);
Route::get('/items/{id}', [ItemController::class, 'show']);
Route::post('/login', [AuthApiController::class, 'login'])->name('login');  
Route::post('/register', [AuthApiController::class, 'register']);



Route::middleware('auth:sanctum')->group(function () { //auth middleware 
    Route::post('/items/order', [CusOderController::class ,'order']);
    Route::middleware('admin')->group(function () {   //coustom middleware  for only admin can get this rout inthis group
        Route::post('/items', [ItemController::class, 'store']);
        Route::put('/items/{id}', [ItemController::class, 'update']);
        Route::delete('/items/{id}', [ItemController::class, 'destroy']);
    });
});


