<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return 'home';
    }

    public function about()
    {
        return view('about');
    }
}
