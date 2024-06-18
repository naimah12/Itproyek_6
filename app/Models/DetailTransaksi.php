<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = ['transaksi_id', 'barang_id', 'jumlah', 'harga_satuan'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id'); // Sesuaikan dengan nama foreign key di tabel detail_transaksi
    }
}
