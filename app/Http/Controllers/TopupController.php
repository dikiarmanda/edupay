<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopupController extends Controller
{
    /**
     * Display the top-up page.
     */
    public function index()
    {
        return view('topup.index');
    }
}
