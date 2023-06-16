<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validation->fails()) {
            return response()->json([
                'message' => 'Fill the form with valid data',
                'data' => $validation->errors(),
            ],422);
        }

        if(!$token = auth()->guard('api')->attempt($validation->validated())) {
            return response()->json([
                'message' => 'Wrong credentials'
            ], 401);
        }

        return response()->json([
            'user'    => auth()->guard('api')->user(),    
            'token'   => $token   
        ], 200);
    }

    public function logout()
    {
        $token = JWTAuth::getToken();

        if(!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first!',  
            ],422);
        }

        $removeToken = JWTAuth::invalidate($token);

        if($removeToken) {
            //return response JSON
            return response()->json([
                'message' => 'Logout berhasil!',  
            ]);
        }
    }
}
