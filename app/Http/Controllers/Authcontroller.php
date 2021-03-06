<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Authcontroller extends Controller
{
    
    public function register(Request $request){


       $validate = $request->validate([

            'name'=>'required',
            'email'=>'required',
            'password'=>'required',

        ]);

       $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> bcrypt($request->password)
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response =[
            'user'=> $user,
            'tokem'=> $token
        ];

        return response($response,201);
    }

    public function login( Request $request){
     
        $validate = $request->validate([

            'email'=>'required',
            'password'=>'required',

        ]);

        // Check email
        $user = User::where('email', $request->email)->first();

        // Check password
        if(!$user || !Hash::check( $request->password, $user->password)) {
            return response([
                'message' => 'Login Is Bad'
            ], 401);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response =[
            'user'=> $user,
            'tokem'=> $token
        ];

        return response($response,201);

    }

    public function logout( Request $request){
        auth()->user()->tokens()->delete();
        
        return [
            'message' => 'Logged out'
        ];

    }
}
