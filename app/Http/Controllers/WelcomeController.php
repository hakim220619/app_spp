<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function index($as = "test")
    {
        return view('login', ['as' => $as]);
    }
}
