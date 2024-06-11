<?php

namespace App\Http\Controllers;

use App\Models\Barang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(){

        $data = Barang::get();

        return view('barangs', compact('data'));
    }

    public function create(){
        return view('createBarang');
    }

    public function store(Request $request){
       // dd($request->all());
       $validator = Validator::make($request->all(),[
            'nama_barang' => 'required',
            'kategori'  => 'required',
            'harga' => 'required',
            'foto' => 'required',
            'stok' => 'required',

       ]);

       if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

       $data['nama_barang']     =  $request->nama_barang;
       $data['kategori']      =  $request->kategori;
       $data['harga']  =  $request->harga;
       $data['foto']  =  $request->foto;
       $data['stok']  =  $request->stok;

       Barang::create($data);

       return redirect()->route('barang.index');
    }
}
