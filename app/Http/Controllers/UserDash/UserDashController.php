<?php

namespace App\Http\Controllers\UserDash;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDashController extends Controller
{
    public function index()
    {
        $data = User::where('role', 'admin')->orderBy('id','desc')->get();

        return response()->json([
            'message' => 'data user',
            'status' => 200,
            'data' => $data
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama' => 'required|min:6|unique:users,nama',
            'username' => 'required|min:6|unique:users,username',
            'role' => 'required',
            'password' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password'
        ],[
            'nama.required' => 'Nama harus di isi',
            'nama.min' => 'Nama minimal 6 karakter',
            'nama.unique' => 'Nama sudah terdaftar',
            'username.required' => 'Username harus di isi',
            'username.min' => 'Username minimal 6 karakter',
            'username.unique' => 'Username sudah terdaftar',
            'role.required' => 'Role harus di pilih',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 6 karakter',
            'konfirmasi_password.required' => 'Konfirmasi password harus di isi',
            'konfirmasi_password.same' => 'Konfirmasi password salah'
        ]);

        $user = User::create([
            'nama' => ucwords(request('nama')),
            'username' => request('username'),
            'role' => request('role'),
            'password' => bcrypt(request('password'))
        ]);

        return response()->json([
            'message' => 'user berhasil ditambahkan',
            'data' => $user
        ]);
    }

    public function show($id)
    {
        $data = User::find($id);

        return response()->json([
            'message' => 'detail data user',
            'status' => 200,
            'data' => $data
        ]);
    }

    public function update($id)
    {
        $data = User::find($id);

        request()->validate([
            'nama' => request('nama') == $data->nama ? 'required|min:6' : 'required|min:6|unique:users,nama',
            'username' => request('username') == $data->username ? 'required|min:6' : 'required|min:6|unique:users,username',
            'role' => 'required',
        ],[
            'nama.required' => 'Nama harus di isi',
            'nama.min' => 'Nama minimal 6 karakter',
            'nama.unique' => 'Nama sudah terdaftar',
            'username.required' => 'Username harus di isi',
            'username.min' => 'Username minimal 6 karakter',
            'username.unique' => 'Username sudah terdaftar',
            'role.required' => 'Role harus di pilih',
        ]);

        $data->update([
            'nama' => request('nama'),
            'username' => request('username'),
            'role' => request('role'),
        ]);

        return response()->json([
            'message' => 'user berhasil di edit',
            'status' => 200,
        ]);
    }

    public function delete($id)
    {
        $data = User::find($id);

        $data->delete();

        return response()->json([
            'message' => 'user berhasil dihapus',
            'status' => 200,
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
