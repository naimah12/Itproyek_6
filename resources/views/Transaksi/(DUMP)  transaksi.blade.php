@extends('layout.mainCreate')

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
                                <tfoot>
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
    </section>

    <!-- Modal -->
    <div class="modal fade" id="transaksiModal" tabindex="-1" role="dialog" aria-labelledby="transaksiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transaksiModalLabel">Konfirmasi Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formTransaksi" action="{{ route('transaksi.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="modalTotalItems">Total Barang</label>
                            <input type="text" class="form-control" id="modalTotalItems" name="total_barang" readonly>
                        </div>
                        <div class="form-group">
                            <label for="modalGrandTotal">Grand Total</label>
                            <input type="text" class="form-control" id="modalGrandTotal" name="grand_total" readonly>
                        </div>
                        <hr>
                        <h5>Daftar Barang:</h5>
                        <ul id="modalDaftarBarang" class="list-unstyled">
                            <!-- Daftar barang akan ditampilkan di sini -->
                        </ul>
                        <hr>
                        <div class="form-group">
                            <label for="modalUangBayar">Uang Bayar</label>
                            <input type="number" class="form-control" id="modalUangBayar" name="uang_bayar"
                                placeholder="Masukkan jumlah uang bayar">
                        </div>
                        <div class="form-group">
                            <label for="modalUangKembali">Uang Kembali</label>
                            <input type="text" class="form-control" id="modalUangKembali" name="uang_kembali" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




<script>
    function addToCart(id, nama, harga) {
    var hargaFormatted = formatRupiah(harga);

    var row = document.createElement('tr');
    row.innerHTML = `
        <td>${nama}</td>
        <td class="hargaSatuan">${hargaFormatted}</td>
        <td>
            <input type="number" class="form-control" value="1" min="1" onchange="updateSubtotal(this, ${harga})">
        </td>
        <td class="subtotal">${hargaFormatted}</td>
        <td>
            <input type="hidden" name="details[]" value='${JSON.stringify({id: id, nama: nama, harga_satuan: harga, jumlah: 1})}'>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFromCart(this)"><i class="fas fa-trash"></i></button>
        </td>
    `;

    var tbody = document.getElementById('detailTransaksi');

    if (tbody.children.length > 0) {
        tbody.insertBefore(row, tbody.children[0]);
    } else {
        tbody.appendChild(row);
    }

    updateSummary();
}

function removeFromCart(button) {
    var item = button.closest('tr');
    item.remove();
    updateSummary();
}

function updateSubtotal(input, harga) {
    var jumlah = input.value;
    var subtotal = jumlah * harga;
    var row = input.closest('tr');
    row.querySelector('.subtotal').textContent = formatRupiah(subtotal);
    row.querySelector('input[name="details[]"]').value = JSON.stringify({
        id: row.querySelector('input[name="details[]"]').dataset.id,
        nama: row.querySelector('input[name="details[]"]').dataset.nama,
        harga_satuan: harga,
        jumlah: jumlah
    });
    updateSummary();
}

function updateSummary() {
    var totalItems = 0;
    var grandTotal = 0;

    var rows = document.querySelectorAll('#detailTransaksi tr');

    rows.forEach(function(row) {
        var jumlah = parseInt(row.querySelector('input[type="number"]').value);
        var hargaSatuan = parseFloat(row.querySelector('input[name="details[]"]').value.split('"harga_satuan":')[1]);
        var subtotal = jumlah * hargaSatuan;

        row.querySelector('.subtotal').textContent = formatRupiah(subtotal);

        totalItems += jumlah;
        grandTotal += subtotal;
    });

    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('grandTotal').textContent = formatRupiah(grandTotal);

    updateModalKembalian();
}

function formatRupiah(angka) {
    var reverse = angka.toString().split('').reverse().join('');
    var ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return 'Rp ' + ribuan;
}

function parseRupiah(rupiah) {
    return parseInt(rupiah.replace(/[^0-9]/g, ''));
}

function updateModalKembalian() {
    var grandTotal = parseRupiah(document.getElementById('grandTotal').textContent);
    var uangBayar = parseFloat(document.getElementById('modalUangBayar').value);
    var uangKembali = uangBayar - grandTotal;

    document.getElementById('modalUangKembali').value = formatRupiah(uangKembali);
}

document.getElementById('completeTransaction').addEventListener('click', function() {
    var totalItems = document.getElementById('totalItems').textContent;
    var grandTotal = document.getElementById('grandTotal').textContent;

    var daftarBarang = [];
    var rows = document.querySelectorAll('#detailTransaksi tr');
    rows.forEach(function(row) {
        var namaBarang = row.querySelector('td:first-child').textContent;
        var hargaSatuan = row.querySelector('.hargaSatuan').textContent;
        var jumlah = row.querySelector('input[type="number"]').value;
        daftarBarang.push({ nama: namaBarang, harga_satuan: hargaSatuan, jumlah: jumlah });
    });

    document.getElementById('modalTotalItems').value = totalItems;
    document.getElementById('modalGrandTotal').value = grandTotal;

    var daftarBarangHtml = '';
    daftarBarang.forEach(function(barang) {
        daftarBarangHtml += `<li>${barang.nama} - ${barang.harga_satuan} - Jumlah: ${barang.jumlah}</li>`;
    });
    document.getElementById('modalDaftarBarang').innerHTML = daftarBarangHtml;

    $('#transaksiModal').modal('show');
});

document.getElementById('formTransaksi').addEventListener('submit', function(e) {
    e.preventDefault();

    var form = e.target;
    var formData = new FormData(form);

    var details = [];
    var rows = document.querySelectorAll('#detailTransaksi tr');
    rows.forEach(function(row) {
        var detail = JSON.parse(row.querySelector('input[name="details[]"]').value);
        details.push(detail);
    });

    formData.append('details', JSON.stringify(details));

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    console.log('Form Data:', formData); // Tambahkan logging di sini

    fetch(form.action, {
        method: form.method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    }).then(response => response.json())
      .then(data => {
          console.log('Response:', data); // Tambahkan logging di sini
          if (data.message === 'Transaksi berhasil disimpan') {
              alert('Transaksi berhasil disimpan');
              location.reload();
          } else {
              alert('Gagal menyimpan transaksi');
          }
      }).catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat menyimpan transaksi');
      });
});


</script>

@endsection