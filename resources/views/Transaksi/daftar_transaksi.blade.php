@extends('layout.main')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Transaksi</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Total Barang</th>
                                        <th>Grand Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('l, j F Y') }}</td>
                                        <td>{{ $transaksi->total_barang }}</td>
                                        <td>Rp {{ number_format($transaksi->grand_total, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('transaksi.show', $transaksi->id) }}"
                                                class="btn btn-sm btn-info">Detail</a>
                                            <form action="{{ route('transaksi.delete', $transaksi->id) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection