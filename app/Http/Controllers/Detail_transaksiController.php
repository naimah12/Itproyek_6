<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Detail_transaksiController extends Controller
{
    public function index(){

        return view("Detail_transaksi/detail");
    }


}
