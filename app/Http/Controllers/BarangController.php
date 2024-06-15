<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

class BarangController extends Controller
{
    public function index(){

        $data = Barang::with('kategori')->get();
        return view('barangs', compact('data'));
    }

    public function create(){

        $kategoris = Kategori::all();
        return view('createBarang', compact('kategoris'));
    }

    public function store(Request $request){
       // dd($request->all());
       $validator = Validator::make($request->all(),[
            'nama_barang' => 'required',
            'id_kategori'  => 'required|exists:kategoris,id_kategori',
            'harga' => 'required',
            'foto' => 'required',

       ]);

       if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

       $data['nama_barang']     =  $request->nama_barang;
       $data['id_kategori']      =  $request->id_kategori;
       $data['harga']  =  $request->harga;
       $data['foto']  =  $request->foto;

       Barang::create($request->all());

       return redirect()->route('barang.index');
    }

    public function edit(Request $request, $id_barang){
        $data = Barang::find($id_barang);
        $kategoris = Kategori::all(); // Ambil juga kategori
        return view('editBarang', compact('data', 'kategoris'));
        
    }

    public function update (Request $request, $id_barang){

      // dd($request->all());
        $validator = Validator::make($request->all(),[
        'nama_barang' => 'required',
        'id_kategori' => 'required|exists:kategoris,id_kategori',
        'harga' => 'required',
        'foto' => 'required',

        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['nama_barang']     =  $request->nama_barang;
        $data['id_kategori']      =  $request->id_kategori;
        $data['harga']  =  $request->harga;
        $data['foto']  =  $request->foto;

        $barang = Barang::find($id_barang);
        $barang->update($request->all());

        return redirect()->route('barang.index');
    
    }

    public function delete (Request $request, $id_barang){
        $data = Barang::find($id_barang);

        if ($data){
            $data->delete();
        }
        return redirect()->route('barang.index');
    }
}
