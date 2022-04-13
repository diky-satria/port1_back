<?php

namespace App\Http\Controllers\User;
 
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return request()->user();
    }

    public function ubah_password()
    {
        request()->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6',
            'konfirmasi_password_baru' => 'required|same:password_baru'
        ],[
            'password_lama.required' => 'Password lama harus di isi',
            'password_baru.required' => 'Password baru harus di isi',
            'password_baru.min' => 'Password minimal 6 karakter',
            'konfirmasi_password_baru.required' => 'Konfirmasi password baru harus di isi',
            'konfirmasi_password_baru.same' => 'Konfirmasi password salah'
        ]);

        $user = User::where('id', Auth::user()->id)->first();

        $password = Auth::user()->password;
        $password_lama = request('password_lama');
        $password_baru = request('password_baru');

        if(password_verify($password_lama, $password)){
            $user->update([
                'password' => bcrypt($password_baru)
            ]);

            return response()->json([
                'message' => 'berhasil',
                'status' => 200
            ]);
        }else{
            throw ValidationException::withMessages([
                'invalid' => ['Password lama salah']
            ]);
        }
    }
}
