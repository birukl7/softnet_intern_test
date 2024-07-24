<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/v1/sayhi', function(Request $request){
    return response()->json([
        'data' => 'hi',
    ]);
});