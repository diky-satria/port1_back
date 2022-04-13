<?php

namespace App\Http\Controllers\Riwayat;

use App\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiwayatController extends Controller
{
    public function show($id)
    {
        $data = History::find($id);

        return response()->json([
            'data' => $data,
            'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/gambar/'
        ]);
    }
}
