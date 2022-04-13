<?php

namespace App\Http\Controllers\Minio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function index()
    {
        return response()->json([
            // 'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/'
            'url' => 'http://localhost:8000/gambar/'
        ]);
    }
}
