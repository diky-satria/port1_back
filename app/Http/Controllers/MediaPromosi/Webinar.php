<?php

namespace App\Http\Controllers\MediaPromosi;

use App\Pos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Webinar extends Controller
{
    public function index()
    {
        $data = Pos::where('kategori', 'Webinar')->orderBy('id','desc')->get();

        return response()->json([
            'data' => $data,
            'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/gambar/'
        ]);
    }

    public function show($id)
    {
        $data = Pos::find($id);

        return response()->json([
            'data' => $data,
            'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/gambar/'
        ]);
    }
}
