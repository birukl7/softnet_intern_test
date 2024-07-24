<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Rules\Password;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/v1/sayhi', function(Request $request){
    return response()->json([
        'data' => 'hi',
    ]);
});


Route::get('v1/register', function(Request $request)
{
    $attrs = FacadesValidator::make($request->all(),[
        'name'=> 'required|string',
        'email'=> 'required|email|unique:users,email',
    //    'phone_no' => ['required', 'regex:/^(09|07)[0-9]{8}$/', 'unique:users,phone_no'],
        'password'=> ['required',Password::min(4), 'confirmed'],
    ]);

    if($attrs->fails()){
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $attrs->errors()
        ], 401);
    }

    $user = User::create([
        'name'=> $request->name,
        'email' => $request->email,
        'phone_no' => $request->phone_no,
        'password'=> $request->password,
    ]);

   // event(new Registered($user));
    // $user->sendEmailVerificationNotification();
    // $adminRole = Role::where('name', 'admin')->where('guard_name', 'api')->first();
    // $user->assignRole($adminRole);
    return response()->json([
        'status' => true,
        'message' => 'Admin User Created Successfully. Email Verification link sent',
        'token' => $user->createToken("API TOKEN")->plainTextToken,
        'data'=>[
            'user'=> $user,
        ]
    ]);
});