<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login() {
        return view('login');
    }

    function logout() {
        return redirect('/login');
    }

    function auth() {
        return redirect('/dashboard');
    }
}
