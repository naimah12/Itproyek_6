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
            'id_kategori'  => 'required',
            'harga' => 'required',
            'foto' => 'required',

       ]);

       if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

       $data['nama_barang']     =  $request->nama_barang;
       $data['id_kategori']      =  $request->id_kategori;
       $data['harga']  =  $request->harga;
       $data['foto']  =  $request->foto;

       Barang::create($data);

       return redirect()->route('barang.index');
    }

    public function edit(Request $request, $id_barang){
        $data = Barang::find($id_barang);

        return view('editBarang', compact('data'));
        
    }

    public function update (Request $request, $id_barang){

      // dd($request->all());
      $validator = Validator::make($request->all(),[
        'nama_barang' => 'required',
        'id_kategori'  => 'required',
        'harga' => 'required',
        'foto' => 'required',

        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['nama_barang']     =  $request->nama_barang;
        $data['id_kategori']      =  $request->id_kategori;
        $data['harga']  =  $request->harga;
        $data['foto']  =  $request->foto;

        Barang::whereId($id_barang)->update($data);

        return redirect()->route('barang.index');
    
    }
}
