<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;

use Illuminate\Support\Facades\Log;


class TransaksiController extends Controller
{
    public function index()
    {
        $dataBarang = Barang::get();

        return view('Transaksi/transaksi', compact('dataBarang'));
    }

    public function daftar()
    {
        // Mengambil semua transaksi dari database
        $transaksis = Transaksi::all();

        // Mengirimkan data transaksi ke view
        return view('Transaksi/daftar_transaksi', [
            'transaksis' => $transaksis
        ]);
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'details' => 'required|array',
            'details.*.id' => 'required|integer',
            'details.*.nama' => 'required|string',
            'details.*.harga_satuan' => 'required|numeric',
            'details.*.jumlah' => 'required|integer|min:1',
            'uang_bayar' => 'required|numeric|min:0',
        ]);

        try {
            // Hitung grand total
            $grandTotal = 0;
            foreach ($request->details as $detail) {
                $subtotal = $detail['harga_satuan'] * $detail['jumlah'];
                $grandTotal += $subtotal;
            }

            // Simpan transaksi
            $transaksi = Transaksi::create([
                'total_barang' => count($request->details),
                'grand_total' => $grandTotal,
                'uang_bayar' => $request->uang_bayar,
                'uang_kembali' => $request->uang_bayar - $grandTotal,
            ]);

            // Simpan detail transaksi
            foreach ($request->details as $detail) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $detail['id'],
                    'jumlah' => $detail['jumlah'],
                    'harga_satuan' => $detail['harga_satuan'],
                ]);
            }

            // Berhasil, redirect ke daftar transaksi
            return redirect()->route('daftar_transaksi')->with('success', 'Transaksi berhasil disimpan');
        } catch (\Exception $e) {
            // Tangkap error
            Log::error('Error while storing transaction: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
    
    
    
}
