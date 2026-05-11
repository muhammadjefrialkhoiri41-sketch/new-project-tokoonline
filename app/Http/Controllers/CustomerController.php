<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // FORM LOGIN
    public function login()
    {
        return view('frontend.auth.login');
    }

    // PROSES LOGIN
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // cek login customer
        if (Auth::guard('customer')->attempt($credentials)) {

            // regenerate session
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        // jika gagal
        return back()->with([
            'error' => 'Email atau password salah'
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}