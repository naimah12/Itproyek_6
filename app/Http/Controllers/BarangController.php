<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

class BarangController extends Controller
{
    public function index(){

        $data = Barang::with('kategori')->get();
        return view('Barang/barangs', compact('data'));
    }

    public function create(){

        $kategoris = Kategori::all();
        return view('Barang/createBarang', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'harga' => 'required|numeric',
            'foto' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    
        // Process the uploaded file
        $image = $request->file('foto');
        $filename = date('Y-m-d') . '-' . $image->getClientOriginalName();
        $path = "foto-barang/" . $filename;
    
        // Store the file
        Storage::disk('public')->put($path, file_get_contents($image));
    
        // Prepare data for insertion
        $data = [
            'nama_barang' => $request->nama_barang,
            'id_kategori' => $request->id_kategori,
            'harga' => $request->harga,
            'foto' => $filename,
        ];
    
        // Create the Barang record
        Barang::create($data);
    
        return redirect()->route('barang.index');
    }
    

    public function edit(Request $request, $id_barang){
        $data = Barang::find($id_barang);
        $kategoris = Kategori::all(); // Ambil juga kategori
        return view('Barang/editBarang', compact('data', 'kategoris'));
        
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
