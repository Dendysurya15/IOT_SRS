<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /*  public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('layout.homepage');
    }

    public function profile()
    {

        $user = User::find(Auth::user()->id);
        return view('layout/profile', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:6',
            // 'no_hp' => 'required',
        ]);

        $request->merge([
            'password' => Hash::make($request->password),
        ]);

        $user = User::find(Auth::user()->id);
        $user->fill($request->all())->save();

        return Redirect::back()->with(['message' => 'Berhasil meng-update data user']);
    }
}
