<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $messages = [
            "email.required" => "Email harus diisi",
            "email.email" => "Email tidak valid",
            "email.exists" => "Email tidak terdaftar",
            "password.required" => "Password harus diisi",
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->role_id == 1) return redirect()->intended('/admin');
            else if (auth()->user()->role_id == 2) return redirect('/operator/pembayaran');
            else if (auth()->user()->role_id == 3) return redirect('/siswa');
        } else {
            return back()->withErrors(['password' => 'Password Salah']);
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect("/");
    }
}
