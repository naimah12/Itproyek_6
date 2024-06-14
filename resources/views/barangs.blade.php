@extends('layout.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">daftar Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('barang.create') }}" class="btn btn-success mb-3">Tambah Data</a>

                    <div class="card">
                        <div class="card-header">

                            <h3 class="card-title">Daftar Barang</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Gambar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->nama_barang }}</td>
                                        <td>{{ $d->id_kategori }}</td>
                                        <td>{{ $d->harga }}</td>
                                        <td>{{ $d->foto }}</td>
                                        <td>
                                            <a href="{{ route ('barang.edit',['id_barang'=> $d->id_barang]) }}" class="btn btn-primary"><i class="fas fa-pen">Edit</i></a>
                                            <a data-toggle="modal" data-target="#modal-hapus{{ $d->id_barang }}" class="btn btn-danger"><i class="fas fa-trash-alt">Hapus</i></a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus{{ $d->id_barang }}">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Konfirmasi hapus data barang</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <p>Apakah yakin mengapus data barang <b> {{ $d->nama_barang }}</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <form action="{{ route('barang.delete',['id_barang'=> $d->id_barang]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancle</button>
                                                    <button type="submit" class="btn btn-primary">Yes</button>
                                                </form>
                                              
                                            </div>
                                          </div>
                                          <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                      </div>
                                      <!-- /.modal -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection