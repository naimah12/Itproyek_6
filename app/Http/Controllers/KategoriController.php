<?php

namespace App\Http\Controllers;

use App\Models\Kategori;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\FuncCall;

class KategoriController extends Controller
{
    public function index (){
       
        $data = Kategori::get();

        return view('kategoris', compact('data'));
    }

    public function create(){
        return view('createKategori');
    }

    public function store(Request $request){
       // dd($request->all());
       $validator = Validator::make($request->all(),[
            'nama_kategori' => 'required',
       ]);

       if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

       $data['nama_kategori']     =  $request->nama_kategori;

       Kategori::create($data);

       return redirect()->route('kategori.index');
    }

    public function edit(Request $request, $id_kategori){
        $data = Kategori::find($id_kategori);

        return view('editKategori', compact('data'));
        
    }

    public function update (Request $request, $id_kategori){

        // dd($request->all());
          $validator = Validator::make($request->all(),[
          'nama_kategori' => 'required',
          
          ]);
  
          if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
  
          $data['nama_kategori']     =  $request->nama_kategori;
  
          Kategori::where('id_kategori', $id_kategori)->update($data);
  
          return redirect()->route('kategori.index');
      
      }

      public function delete (Request $request, $id_kategori){
        $data = Kategori::find($id_kategori);

        if ($data){
            $data->delete();
        }
        return redirect()->route('kategori.index');
    }
}
