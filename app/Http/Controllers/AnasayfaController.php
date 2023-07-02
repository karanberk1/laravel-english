<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnasayfaController extends Controller
{
    public function index(Request $request)
    {
        return view('anasayfa');
    }
}
