<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login()
    {
        request()->validate([
            'username' => 'required',
            'password' => 'required|min:6'
        ],[
            'username.required' => 'Username harus di isi',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        if(!Auth::attempt(request()->only('username','password'))){
            throw ValidationException::withMessages([
                'invalid' => ['Username dan password tidak sesuai']
            ]);
            
            return response()->json([
                'message' => 'invalid credential'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60*10000);

        return response()->json([
            'message' => 'success',
            // 'token' => $token
        ])->withCookie($cookie);

    }

    public function user()
    {
        return Auth::user();
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response()->json([
            'message' => 'success'
        ])->withCookie($cookie);
    }
}
