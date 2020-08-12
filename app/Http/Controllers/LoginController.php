<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
        $user = User::where('email', $credentials['email'])->first();
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Unauthorized',
                'errors' => ['email' => ['The provided credentials are incorrect.']]],
                401);
        }
        $infoToken = $user->createToken($credentials['email'], ['sever:createNewToken']);
        return response()->json([
            'token_access' => $infoToken->plainTextToken,
            'id_token' => $infoToken->accessToken->id,
            'email' => $credentials['email']
        ]);
    }

    public function logout(Request $request)
    {
        $user = User::where('email', $request->emailLogin)->first();
        $user->tokens()->where('id', $request->idToken)->delete();
        Auth::logout();
    }
}
