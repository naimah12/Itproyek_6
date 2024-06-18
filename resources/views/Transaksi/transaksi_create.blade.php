@extends('layout.main')

@section('content')
<div class="content-wrapper">



    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Bagian kiri: Detail Transaksi -->
                <div class="col-md-5 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Transaksi</h3>
                            <div class="card-tools">
                                <span class="badge badge-secondary">label</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th style="width: 10px">Subtotal</th>
                                        <th style="width: 10px"><i class="fas fa-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="detailTransaksi">
                                    {{-- Item transaksi akan ditambahkan di sini --}}
                                </tbody>
                                <tfoot style="background-color: aqua;">
                                    <tr>
                                        <td><strong>Total Barang:</strong></td>
                                        <td id="totalItems">0</td>
                                        <td><strong>Grand Total:</strong></td>
                                        <td id="grandTotal">Rp 0</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="card-footer">
                                <button id="completeTransaction" class="btn btn-primary">Selesaikan Transaksi</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bagian kanan: List Barang -->
                <div class="col-md-7 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Barang</h3>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($dataBarang as $b)
                                <div class="col-md-3">
                                    <div class="card card-outline card-dark">
                                        <div class="card-body text-center">
                                            <img width="120" height="120"
                                                src="{{ asset('storage/foto-barang/'.$b->foto) }}" alt="">
                                            <h5 class="card-title-centered mt-2">{{ $b->nama_barang }}</h5>
                                            <p class="card-text">Rp {{ number_format($b->harga, 0, ',', '.') }}</p>
                                            <button style="border-radius: 20px" type="button"
                                                class="btn btn-block btn-outline-success"
                                                onclick="addToCart({{ $b->id_barang }}, '{{ $b->nama_barang }}', {{ $b->harga }})">Add
                                                to Cart</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="modalPembayaranLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <!-- modal-lg untuk modal ukuran besar -->
                <div class="modal-content">
                    <form id="formTransaksi" action="{{ route('transaksi.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPembayaranLabel">Detail Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Sisi pertama (kolom kiri) -->
                                    <div class="form-group">
                                        <label for="totalBarang">Total Barang:</label>
                                        <input type="text" class="form-control" id="totalBarang" name="total_barang"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="grandTotal">Grand Total:</label>
                                        <input type="text" class="form-control" id="grandTotalModal" name="grand_total"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal Transaksi :</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Sisi kedua (kolom kanan) -->
                                    <div class="form-group">
                                        <label>Daftar Barang:</label>
                                        <ul class="list-group" id="daftarBarangModal">
                                            <!-- Daftar barang akan ditampilkan di sini -->
                                        </ul>
                                    </div>
                                    <div class="form-group">
                                        <label for="hargaBayar">Harga Bayar:</label>
                                        <input type="number" class="form-control" id="hargaBayar" name="harga_bayar"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="hargaKembali">Harga Kembali:</label>
                                        <input type="text" class="form-control" id="hargaKembali" name="harga_kembali"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </section>


</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    var totalItems = 0;
var grandTotal = 0;
var daftarBarang = [];

// Fungsi untuk menambahkan barang ke detail transaksi
function addToCart(id, nama, harga) {
    // Tambahkan barang ke daftarBarang
    var existingItem = daftarBarang.find(item => item.id === id);
    if (existingItem) {
        existingItem.jumlah++;
        existingItem.subtotal = existingItem.jumlah * existingItem.harga;
    } else {
        daftarBarang.push({ id: id, nama: nama, harga: harga, jumlah: 1, subtotal: harga });
    }

    // Update total barang dan grand total
    updateTotal();

    // Update tampilan
    updateCartView();
}

// Fungsi untuk menghapus barang dari detail transaksi
function removeFromCart(id) {
    // Cari indeks barang yang akan dihapus dari daftarBarang
    var index = daftarBarang.findIndex(barang => barang.id === id);
    if (index !== -1) {
        // Hapus barang dari daftarBarang
        daftarBarang.splice(index, 1);

        // Update total barang dan grand total
        updateTotal();

        // Update tampilan
        updateCartView();
    }
}

// Fungsi untuk mengupdate jumlah barang
function updateJumlah(id, jumlah) {
    // Cari barang berdasarkan id
    var barang = daftarBarang.find(barang => barang.id === id);
    if (barang) {
        // Update jumlah barang dan subtotal
        barang.jumlah = parseInt(jumlah);
        barang.subtotal = barang.jumlah * barang.harga;

        // Update total barang dan grand total
        updateTotal();

        // Update tampilan
        updateCartView();
    }
}

// Fungsi untuk mengupdate total barang dan grand total
function updateTotal() {
    totalItems = daftarBarang.reduce((acc, curr) => acc + curr.jumlah, 0);
    grandTotal = daftarBarang.reduce((acc, curr) => acc + curr.subtotal, 0);
}





// Fungsi untuk memperbarui tampilan detail transaksi
function updateCartView() {
    var detailTransaksi = document.getElementById('detailTransaksi');
    detailTransaksi.innerHTML = '';
    daftarBarang.forEach(barang => {
        var listItem = document.createElement('tr');
        listItem.innerHTML = `
            <td>${barang.nama}</td>
            <td>Rp ${barang.harga.toLocaleString('id-ID')}</td>
            <td>
                <input type="number" value="${barang.jumlah}" onchange="updateJumlah(${barang.id}, this.value)" min="1">
            </td>
            <td>Rp ${barang.subtotal.toLocaleString('id-ID')}</td>
            <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFromCart(${barang.id})"><i class="fas fa-trash"></i></button></td>
        `;
        detailTransaksi.appendChild(listItem);
    });

    // Update total barang dan grand total
    document.getElementById('totalItems').innerText = totalItems;
    document.getElementById('grandTotal').innerText = "Rp " + grandTotal.toLocaleString('id-ID');
}


// ###############################################################----------------------------------------------------------------

// Fungsi untuk menampilkan modal pembayaran
document.getElementById('completeTransaction').addEventListener('click', function() {
    // Update nilai di modal
    document.getElementById('totalBarang').value = totalItems;
// Tampilkan grand total di modal tanpa "Rp " dan dengan format numerik
document.getElementById('grandTotalModal').value = grandTotal.toLocaleString('id-ID');

    // Tampilkan daftar barang di modal
    var daftarBarangModal = document.getElementById('daftarBarangModal');
    daftarBarangModal.innerHTML = '';
    daftarBarang.forEach((barang, index) => {
        var listItem = document.createElement('li');
        listItem.className = 'list-group-item';
        listItem.innerText = `${barang.nama} - Rp ${barang.harga.toLocaleString('id-ID')}`;
        daftarBarangModal.appendChild(listItem);

        // Tambahkan input-hidden untuk setiap item barang
        var inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = `daftar_barang[${index}][id]`; // Sesuaikan dengan nama atribut yang diharapkan oleh Laravel
        inputId.value = barang.id;
        daftarBarangModal.appendChild(inputId);

        var inputJumlah = document.createElement('input');
        inputJumlah.type = 'hidden';
        inputJumlah.name = `daftar_barang[${index}][jumlah]`; // Sesuaikan dengan nama atribut yang diharapkan oleh Laravel
        inputJumlah.value = barang.jumlah;
        daftarBarangModal.appendChild(inputJumlah);

        var inputSubTotal = document.createElement('input');
        inputSubTotal.type = 'hidden';
        inputSubTotal.name = `daftar_barang[${index}][sub_total]`; // Sesuaikan dengan nama atribut yang diharapkan oleh Laravel
        inputSubTotal.value = barang.subtotal;
        daftarBarangModal.appendChild(inputSubTotal);
    });

    // Tampilkan modal
    $('#modalPembayaran').modal('show');
});


    // Fungsi untuk menghitung harga kembali
    document.getElementById('hargaBayar').addEventListener('input', function() {
        var hargaBayar = parseFloat(this.value);
        var kembalian = hargaBayar - grandTotal;
        document.getElementById('hargaKembali').value =kembalian.toLocaleString('id-ID');
    });

    // Fungsi untuk menyimpan transaksi
    function simpanTransaksi() {
    var hargaBayar = parseFloat(document.getElementById('hargaBayar').value);
    var kembalian = hargaBayar - grandTotal;

    // Set nilai-nilai input yang dihidden dengan nilai yang sesuai
    document.getElementById('totalItemsInput').value = totalItems;
    document.getElementById('grandTotalInput').value = grandTotal;
    document.getElementById('hargaKembali').value = kembalian;

    // Lakukan proses simpan transaksi ke backend (misalnya dengan AJAX)
    // Pastikan form ini di-submit
    document.getElementById('formTransaksi').submit();

    // Setelah transaksi disimpan, bisa tambahkan logika untuk mengosongkan detail transaksi
    totalItems = 0;
    grandTotal = 0;
    daftarBarang = [];
    document.getElementById('totalItems').innerText = totalItems;
    document.getElementById('grandTotal').innerText = "Rp 0";
    document.getElementById('hargaBayar').value = "";
    document.getElementById('hargaKembali').value = "Rp 0";
    document.getElementById('detailTransaksi').innerHTML = '';

    // Tutup modal pembayaran
    $('#modalPembayaran').modal('hide');
}


</script>




@endsection