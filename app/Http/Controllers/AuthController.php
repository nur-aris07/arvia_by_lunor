<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function login() {
        return view('login');
    }

    function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate();
        return redirect('/login');
    }

    function auth(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|max:100',
            'password' => 'required|string|max:20|min:8',
            'captcha'  => 'required|captcha'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Validasi gagal, silakan cek kembali input');
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Kombinasi Email dan Password tidak ditemukan.');
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }
}
