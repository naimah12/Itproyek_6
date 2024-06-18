@extends('layout.main')

@section('content')
<div class="content-wrapper">



    <section class="content">
        <div class="container-fluid">
            <div class="row">
                    <!-- Bagian kiri: Detail Transaksi -->
                    <div class="col-md-6 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Transaksi</h3>
                                <div class="card-tools">
                                    <span class="badge badge-secondary">label</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-group mb-3" id="detailTransaksi">
                                    <!-- Item detail transaksi akan ditambahkan disini -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Bagian kanan: List Barang -->
                    <div class="col-md-6 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Barang</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="list-group" id="listBarang">
                                    <!-- Daftar barang akan ditampilkan disini -->
                                    <button type="button" class="list-group-item list-group-item-action"
                                        onclick="addToCart(1, 'Barang A', 100)">Barang A - Rp 100</button>
                                    <button type="button" class="list-group-item list-group-item-action"
                                        onclick="addToCart(2, 'Barang B', 150)">Barang B - Rp 150</button>
                                    <button type="button" class="list-group-item list-group-item-action"
                                        onclick="addToCart(3, 'Barang C', 200)">Barang C - Rp 200</button>
                                </div>
                            </div>
                        </div>

                    </div>

            </div>
        </div>
    </section>


</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Fungsi untuk menambahkan barang ke detail transaksi
    function addToCart(id, nama, harga) {
        // Buat elemen baru untuk detail transaksi
        var listItem = document.createElement('li');
        listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
        listItem.innerHTML = `
            <span>${nama} - Rp ${harga}</span>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFromCart(this)">-</button>
        `;

        // Tambahkan atribut data-id pada elemen untuk identifikasi
        listItem.setAttribute('data-id', id);

        // Tambahkan elemen ke dalam ul detailTransaksi
        document.getElementById('detailTransaksi').appendChild(listItem);
    }

    // Fungsi untuk menghapus barang dari detail transaksi
    function removeFromCart(button) {
        var item = button.parentElement; // Ambil elemen li yang berisi tombol hapus
        item.remove(); // Hapus elemen li dari detail transaksi
    }
</script>



@endsection