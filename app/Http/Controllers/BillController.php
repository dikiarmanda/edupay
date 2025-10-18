<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillController extends Controller
{
  /**
   * Display the bills page.
   */
  public function index()
  {
    return view('tagihan.index');
  }
}
