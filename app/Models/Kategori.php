<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kategori';
    
    protected $fillable = [
        
        'nama_kategori'
    ];

   // Relasi ke model Barang
   public function barangs()
   {
       return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
   }
}

