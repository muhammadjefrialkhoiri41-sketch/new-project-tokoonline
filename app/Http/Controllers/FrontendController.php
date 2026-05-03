<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class FrontendController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('id', 'desc')->get();

        return view('frontend.beranda', compact('kategori'));
    }
}