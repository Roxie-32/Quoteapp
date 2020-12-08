<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

use Tymon\JWTAuth\Exceptions\JWTException;


class UserController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);

        $user = new User([
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'password'=> bcrypt($request->input('password'))
        ]);

        $user->save();

        return response()->json([
            'meessage'=>'Successfully Created user'
        ],201);
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required'
        ]);
    
        $credentials= $request->only('email', 'password');
        try{
            if (!$token = JWTAuth::attempt($credentials)) {
                   return response()->json([
                       'error'=>'invalid Credentials'
                   ], 401);
                }
        } catch (JWTException $e) {
                return response()->json([
                    'error'=>'Could not create token'
                ], 500);
        }
        return response()->json([
            'token'=> $token
        ],200);
    }
}