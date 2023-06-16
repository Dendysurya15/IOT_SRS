<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $user = DB::connection('mysql2')->table('pengguna')
            ->get();

        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = DB::connection('mysql2')->table('pengguna')->where('email', $request->email)
            ->orWhere('nama_lengkap', $request->email)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email atau Password Salah');
        } else if ($request->password != $user->password) {
            return redirect()->back()->with('error', 'Email atau Password Salah');
        } else {
            session(['user_id' => $user->user_id, 'user_name' => $user->nama_lengkap, 'departemen' => $user->departemen]);
            if (Session::has('url.intended')) {
                $intendedUrl = Session::get('url.intended');
                Session::forget('url.intended');
                return redirect()->to($intendedUrl);
            } else {
                return redirect()->intended('dashboard');
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
