<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    function index() {
        return view('invitations.index');
    }
}
