<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function splash()
    {
        return view('splash');
    }

    public function semuaMenu()
    {
        return view('semua-menu');
    }

    public function bantuan()
    {
        return view('bantuan');
    }
}
