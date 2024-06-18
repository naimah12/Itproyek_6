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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tanggal Transaksi</th>
                                        <th>Total Barang</th>
                                        <th>Grand Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $transaksi->created_at->format('d M Y H:i:s') }}</td>
                                        <td>{{ $transaksi->total_barang }}</td>
                                        <td>{{ $transaksi->grand_total }}</td>
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