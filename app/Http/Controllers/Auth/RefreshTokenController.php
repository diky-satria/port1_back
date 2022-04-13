<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
