<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthControlller extends Controller
{
    function index()
    {
        return view('auth.login');
    }

    function submitLogin(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login dengan kredensial
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Cegah session fixation
            return redirect()->route('dashboard');
        }else {
            // Jika gagal, kembali dengan input lama
            return redirect()->back()->withInput($request->only('email', 'remember'))->with(
                'gagal', 'Email atau password salah.',);
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('welcome');
    }
}
