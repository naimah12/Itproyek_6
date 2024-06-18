<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['total_barang', 'grand_total', 'uang_bayar', 'uang_kembali'];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
