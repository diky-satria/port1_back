<?php

namespace App\Http\Controllers\GalleryAdmin;

use App\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GalleryAdminController extends Controller
{
    public function index()
    {
        $gallery = Gallery::orderBy('id','desc')->get();

        // $data = [];
        // foreach($gallery as $g){
        //     $data[] = [
        //         'id' => $g->id,
        //         'judul' => $g->judul,
        //         'kategori' => $g->kategori,
        //         'deskripsi' => $g->deskripsi == null ? '---' : $g->deskripsi,
        //         'gambar' => $g->gambar
        //     ];
        // }

        return response()->json([
            'data' => $gallery,
            // 'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/gallery/'
            'url' => 'http://localhost:8000/gambar/gallery/'
        ]);
    }

    public function show($id){
        $data = Gallery::find($id);

        return response()->json([
            'data' => $data,
            'url' => 'http://localhost:8000/gambar/gallery/'
        ]);
    }

    public function store()
    {
        request()->validate([
            'judul' => 'required|unique:galleries,judul',
            'kategori' => 'required',
            'gambar' => 'required|mimes:jpg,png,jpeg,gif|max:1024'
        ],[
            'judul.required' => 'Judul harus di isi',
            'judul.unique' => 'Judul ini sudah terdaftar',
            'kategori.required' => 'Kategori harus di pilih',
            'gambar.required' => 'Gambar harus di isi',
            'gambar.mimes' => 'Format gambar harus jpg/png/jpeg/gif',
            'gambar.max' => 'Ukuran gambar maksimal 1 MB'
        ]);

        if ($gambar = request()->file('gambar')) {
            $upload = time() . '.' . $gambar->getClientOriginalExtension();
            // $gambar->storeAs('gallery/', $upload, 'minio');  -> upload ke minio
            $gambar->move(public_path('gambar/gallery/'), $upload);  
        }

        Gallery::create([
            'judul' => request('judul'),
            'kategori' => request('kategori'),
            'deskripsi' => request('deskripsi'),
            'gambar' => $upload
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'berhasil'
        ]);
    }

    public function update($id)
    {
        $data = Gallery::find($id);

        request()->validate([
            'judul' => request('judul') == $data->judul ? 'required' : 'required|unique:galleries,judul',
            'kategori' => 'required',
            'gambar' => request()->file('gambar') ? 'mimes:jpg,png,jpeg,gif|max:1024' : ''
        ],[
            'judul.required' => 'Judul harus di isi',
            'judul.unique' => 'Judul ini sudah terdaftar',
            'kategori.required' => 'Kategori harus di pilih',
            'gambar.mimes' => 'Format gambar harus jpg/png/jpeg/gif',
            'gambar.max' => 'Ukuran gambar maksimal 1 MB'
        ]);

        $gambar = request()->file('gambar');
        if($gambar){
            // hapus gambar lama
            $gambar_lama = $data->gambar;
            if($gambar_lama){
                // Storage::cloud()->delete('gallery/'.$gambar_lama); -> hapus gambar di minio
                unlink('gambar/gallery/'. $gambar_lama);
            }

            // upload gambar baru
            $upload = time() . '.' . $gambar->getClientOriginalExtension();
            // $gambar->storeAs('gallery/', $upload, 'minio'); -> upload ke minio
            $gambar->move(public_path('gambar/gallery/'), $upload);  
        }
        
        $data->update([
            'judul' => request('judul'),
            'kategori' => request('kategori'),
            'deskripsi' => request('deskripsi') == 'null' ? NULL : request('deskripsi'),
            'gambar' => request()->file('gambar') ? $upload : $data->gambar
        ]);

        return response()->json([
            'message' => 'berhasil',
            'status' => 200
        ]);
    }

    public function delete($id)
    {
        $data = Gallery::find($id);

        // hapus gambar lama
        $gambar_lama = $data->gambar;
        if($gambar_lama){
            // Storage::cloud()->delete('gallery/'.$gambar_lama); -> hapus gambar di minio
            unlink('gambar/gallery/'. $gambar_lama);
        }

        $data->delete();

        return response()->json([
            'message' => 'berhasil',
            'status' => 200
        ]);
    }
}
