<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code'=> 400,
                'message'=> 'Bad request'
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status_code'=> 200,
            'message'=> 'User account has been created'
        ]);
    }
    
    public function login(Request $request) {
        $credentials = $request -> validate([
            'email' => 'required|string',
            'password' => 'required|string'
            ]);

        if (!Auth::attempt([$credentials])) {
            return response()->json([
                'status_code'=> 400,
                'message'=> 'Bad request'
            ]);
        }

        // $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return response()->json([
            'status_code'=> 200,
            // 'token'=> $accessToken,
            'user'=> Auth::user(),
        ]);
    }

    public function isLogin() {
        return response()->json([
            'user'=> Auth::user(),
        ]);
    }
}
