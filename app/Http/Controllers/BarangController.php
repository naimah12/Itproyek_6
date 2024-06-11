<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Contracts\View\View;

class BarangController extends Controller
{
    public function index(): View
    {
        $barangs = Barang::all();

        return view('barangs', compact('barangs'));
    }

    public function create(){
        return view('createBarang');
    }
}
