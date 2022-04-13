<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // $headers = apache_request_headers();
        // $request->headers->set('Authorization', $headers['authorization']);
        // auth()->invalidate(true);
        auth()->logout();

        return response()->json([
            // 'status' => 200,
            'message' => 'berhasil logout'
        ]);
    }
}
