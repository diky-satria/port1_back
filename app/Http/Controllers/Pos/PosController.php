<?php

namespace App\Http\Controllers\Pos;

use App\Pos;
use App\User;
use App\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PosController extends Controller
{

    public function index()
    {
        $data = Pos::orderBy('id','DESC')->get();

        return response()->json([
            'data' => $data,
            // 'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/gambar/'
            'url' => 'http://localhost:8000/gambar/bimtek/'

        ]);
    }

    public function show($id)
    {
        $data = Pos::find($id);

        $d_riwayat = History::where('id_pos', $id)->orderBy('id','desc')->first();

        $r = History::where('id_pos', $id)->orderBy('id','desc')->get();
        $riwayat = [];

        foreach($r as $rw){
            $riwayat[] = [
                'id' => $rw->id,
                'gambar' => $rw->gambar,
                'judul' => $rw->judul,
                'konten' => $rw->konten,
                'tanggal' => date('d-M-Y H:i', strtotime($rw->created_at)) 
            ]; 
        }

        return response()->json([
            'message' => 'semua data postingan',
            'status' => 200,
            'data' => $data,
            // 'url' => 'https://cdnp2sdm.meetaza.com/p2sdm/gambar/',
            'url' => 'http://localhost:8000/gambar/bimtek/',
            'data_riwayat' => $d_riwayat,
            'riwayat' => $riwayat
        ]);
    }

    public function store()
    {
        request()->validate([
            'judul' => 'required|unique:pos,judul',
            'kategori' => 'required',
            'konten' => 'required|min:10',
            'gambar' => request()->file('gambar') ? 'mimes:jpg,png,jpeg,gif|max:1024' : ''
        ],[
            'judul.required' => 'Judul harus di isi',
            'judul.unique' => 'Judul sudah terdaftar',
            'kategori.required' => 'Kategori harus di isi',
            'konten.required' => 'Konten harus di isi',
            'konten.min' => 'Konten minimal 10 karakter',
            'gambar.mimes' => 'Format gambar harus jpg/png/jpeg/gif',
            'gambar.max' => 'Ukuran gambar maksimal 1 MB'
        ]);

        date_default_timezone_set('Asia/Jakarta');

        if ($gambar = request()->file('gambar')) {
            $upload = time() . '.' . $gambar->getClientOriginalExtension();
            // $gambar->storeAs('gambar/', $upload, 'minio');   -> upload ke minio
            $gambar->move(public_path('gambar/bimtek/'), $upload);

            $data = Pos::create([
                'judul' => ucwords(request('judul')),
                'kategori' => request('kategori'),
                'konten' => request('konten'),
                'gambar' => $upload,
                'dibuat_oleh' => Auth::user()->nama
            ]); 
            History::create([
                'id_pos' => $data->id,
                'judul' => ucwords(request('judul')),
                'konten' => request('konten'),
                'gambar' => $upload
            ]);
        }else{
            $data = Pos::create([
                'judul' => ucwords(request('judul')),
                'kategori' => request('kategori'),
                'konten' => request('konten'),
                'gambar' => 'dummy-horizontal.jpg',
                'dibuat_oleh' => Auth::user()->nama
            ]);
            History::create([
                'id_pos' => $data->id,
                'judul' => ucwords(request('judul')),
                'konten' => request('konten'),
                'gambar' => 'dummy-horizontal.jpg'
            ]);
        }

        return response()->json([
            'message' => 'pos berhasil ditambahkan'
        ]);
    }

    public function update($id)
    {
        $data = Pos::find($id);

        request()->validate([
            'judul' => request('judul') == $data->judul ? 'required' : 'required|unique:pos,judul',
            'kategori' => 'required',
            'konten' => 'required|min:10',
        ],[
            'judul.required' => 'Judul harus di isi',
            'judul.unique' => 'Judul sudah terdaftar',
            'kategori.required' => 'Kategori harus di isi',
            'konten.required' => 'Konten harus di isi',
            'konten.min' => 'Konten minimal 10 karakter',
        ]);

        date_default_timezone_set('Asia/Jakarta');

        $gambar = request()->file('gambar');
        if($gambar){
            // jika ada gambar nya maka validasi 
            request()->validate([
                'gambar' => 'mimes:jpg,png,jpeg,gif|max:1024'
            ],[
                'gambar.mimes' => 'Format file harus jpg/jpeg/png/gif',
                'gambar.max' => 'Ukuran gambar maximal 1 MB'
            ]);
            
            // jika ada gambar yang akan diedit maka hapus gambar lama
            // $gambar_lama = $data->gambar;
            // if($gambar_lama){
            //     Storage::cloud()->delete('gambar/'.$gambar_lama);
            // }

            // upload gambar lama dengan yang baru
            $upload = time() . '.' . $gambar->getClientOriginalExtension();
            // $gambar->storeAs('gambar/', $upload, 'minio'); -> upload ke minio
            $gambar->move(public_path('gambar/bimtek/'), $upload); 

            // update 
            $data->update([
                'judul' => ucwords(request('judul')),
                'kategori' => request('kategori'),
                'konten' => request('konten'),
                'gambar' => $upload
            ]);

            // tambah ke table riwayat
            History::create([
                'id_pos' => $data->id,
                'judul' => ucwords(request('judul')),
                'konten' => request('konten'),
                'gambar' => $upload
            ]);

        }else{
            $data->update([
                'judul' => ucwords(request('judul')),
                'kategori' => request('kategori'),
                'konten' => request('konten'),
            ]);

            //ambil data riwayat yang akan diedit (branch awal)
            $d_riwayat = History::where('id_pos', $id)->orderBy('id','desc')->first();
            $d_riwayat->update([
                'judul' => ucwords(request('judul')),
                'konten' => request('konten')
            ]);
        }

        return response()->json([
            'message' => 'pos berhasil ditambahkan'
        ]);
    }

    public function destroy($id)
    {
        $data = Pos::find($id);

        $gambar_lama = $data->gambar;
        if($gambar_lama){
            Storage::cloud()->delete('gambar/'.$gambar_lama);
        }

        $data->delete();

        return response()->json([
            'message' => 'pos berhasil dihapus'
        ]);
    }

    public function test()
    {
        $data = User::all();

        return response()->json([
            'data' => $data
        ]);
    }
}
