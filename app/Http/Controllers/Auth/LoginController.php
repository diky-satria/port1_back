<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        request()->validate([
            'username' => 'required',
            'password' => 'required|min:6'
        ],[
            'username.required' => 'Username harus di isi',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        if (! $token = auth()->attempt($request->only('username','password'))) {
            throw ValidationException::withMessages([
                'invalid' => ['Username dan password tidak sesuai']
            ]);
            return response()->json([
                'status' => 401,
                'message' => 'username dan password tidak sesuai'
            ], 401);
        }


        return response()->json([
            'status' => 200,
            'message' => 'berhasil login',
            'data' => [
                // 'user' => auth()->user(),
                'token' => $token
            ]
        ], 200);
    }
}
