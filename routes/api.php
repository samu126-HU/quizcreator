<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('categories')->group(function () { 
    Route::get('list',[CategoryController::class,'index']);
    Route::post('add',[CategoryController::class,'store']);
    Route::delete('destroy/{id}',[CategoryController::class,'destroy']);
    Route::post('update/{id}',[CategoryController::class,'update']);

});