@extends('layout.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tambah barang v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Form Tambah barang</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Barang</label>
                                        <input type="text" class="form-control" name="nama_barang" id="exampleInputnama_barang1"
                                            placeholder="Masukkan Nama Barang">
                                        @error('nama_barang')
                                        <small color="red"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Kategori</label>
                                        <input type="text" class="form-control" name="kategori" id="exampleInputEmail1"
                                            placeholder="Enter kategori">
                                        @error('kategori')
                                        <small color="red"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Harga</label>
                                        <input type="text" class="form-control" name="harga" id="exampleInputEmail1"
                                            placeholder="Enter harga">
                                        @error('harga')
                                        <small color="red"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Foto</label>
                                        <input type="text" class="form-control" name="foto" id="exampleInputEmail1"
                                            placeholder="Enter foto">
                                        @error('foto')
                                        <small color="red"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Stok</label>
                                        <input type="text" class="form-control" name="stok" id="exampleInputEmail1"
                                            placeholder="Enter stok">
                                        @error('stok')
                                        <small color="red"> {{ $message }} </small>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose
                                                    file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                    </div> --}}
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.card -->
    <!-- /.content -->
</div>
@endsection