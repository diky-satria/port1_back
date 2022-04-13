<?php

namespace App\Http\Controllers\Gallery;

use App\Gallery;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        $data1 = Gallery::where('kategori','Pics One')->orderBy('id','desc')->limit(1)->get();
        $data2 = Gallery::where('kategori','Pics Two')->orderBy('id','desc')->limit(1)->get();
        $data3 = Gallery::where('kategori','Pics Three')->orderBy('id','desc')->limit(1)->get();

        return response()->json([
            'message' => 'berhasil',
            // 'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/gallery/',
            'url' => 'http://localhost:8000/gambar/gallery',
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
        ]);
    }

    public function show($kategori)
    {
        $data = Gallery::where('kategori', $kategori)->orderBy('id','desc')->get();

        return response()->json([
            'message' => 'detail data',
            // 'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/gallery/',
            'url' => 'http://localhost:8000/gambar/gallery/',
            'data' => $data
        ]);
    }
}
