<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {

            return response()->json([
                'message' => 'Email ou mot de passe incorrect'
            ], 401);
        }

        return response()->json([
            'message' => 'Login réussi'
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logout réussi'
        ]);
    }
}