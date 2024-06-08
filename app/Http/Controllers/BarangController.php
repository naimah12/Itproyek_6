<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Barang;
use Illuminate\View\View;


class BarangController extends Controller
{
    public function index() : View
    {
        $barangs = Barang::all();

        return view('barangs', compact('barangs'));

    }
}
