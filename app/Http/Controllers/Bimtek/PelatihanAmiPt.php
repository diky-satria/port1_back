<?php

namespace App\Http\Controllers\Bimtek;

use App\Pos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PelatihanAmiPt extends Controller
{
    public function index()
    {
        $data = Pos::where('kategori', 'Pelatihan AMI-PT')->orderBy('id','desc')->get();

        return response()->json([
            'data' => $data,
            // 'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/gambar/' 
            'url' => 'http://localhost:8000/gambar/bimtek/'
        ]);
    }

    public function show($id)
    {
        $data = Pos::find($id);

        return response()->json([
            'data' => $data,
            // 'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/gambar/'
            'url' => 'http://localhost:8000/gambar/bimtek/'
        ]);
    }
}
