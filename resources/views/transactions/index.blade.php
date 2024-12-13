@extends('layouts.app')

@section('title', 'SIMTEK | Data Transaksi')

@section('content')

<h1 class="mt-4">Data Transaksi</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Transaksi</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Data Transaksi
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
            Tambah Data
        </button>
    </div>
    @if(Session::has('success'))
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Sukses</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                        <p class="mt-3">{{ Session::get('success') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('transactions') }}'">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>ID Transaksi</th>
                    <th>Nama Produk</th>
                    <th>Status Transaksi</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $rs)
                    <tr>
                        <td>{{ $rs->tanggal_transaksi }}</td>
                        <td>{{ $rs->transaksi_id }}</td>
                        <td>{{ $rs->medicine ? $rs->medicine->nama_obat : $rs->medicinedevice->nama_alatkesehatan }}</td>
                        <td>
                            @if ($rs->status === 'buy')
                                <span class="badge bg-success">BELI</span>
                            @elseif ($rs->status === 'sale')
                                <span class="badge bg-warning">JUAL</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($rs->medicine ? $rs->medicine->harga : $rs->medicinedevice->harga, 0, ',', '.') }}</td>
                        <td>{{ $rs->jumlah }}</td>
                        <td>{{ $rs->medicine ? $rs->medicine->satuan->nama_satuan : $rs->medicinedevice->satuan->nama_satuan }}</td>
                        <td>Rp {{ number_format($rs->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <div aria-label="Basic example">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" id="actionButton{{ $rs->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="actionButton{{ $rs->id }}">
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#showTransactionModal{{ $rs->id }}">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#editTransactionModal{{ $rs->id }}">
                                        <i class="fas fa-edit"></i> Ubah
                                    </button>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#deleteTransactionModal{{ $rs->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Detail -->
                    <div class="modal fade" id="showTransactionModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="showTransactionModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showTransactionModalLabel{{ $rs->id }}">Detail Data Transaksi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="tanggal">Tanggal Transaksi</label>
                                        <input type="text" class="form-control" id="tanggal" value="{{ $rs->created_at->format('d-m-Y') }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_transaksi">ID Transaksi</label>
                                        <input type="text" class="form-control" id="id_transaksi" value="{{ $rs->transaksi_id }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_produk">Nama Produk</label>
                                        <input type="text" class="form-control" id="nama_produk" value="{{ $rs->medicine ? $rs->medicine->nama_obat : $rs->medicinedevice->nama_alatkesehatan }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status">Status Transaksi :</label>
                                        @if ($rs->status === 'buy')
                                            <span class="badge bg-success">BELI</span>
                                        @elseif ($rs->status === 'sale')
                                            <span class="badge bg-warning">JUAL</span>
                                        @else
                                            <span class="badge bg-secondary">UNKNOWN</span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="text" class="form-control" id="jumlah" value="{{ $rs->jumlah }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="total_harga">Total Harga</label>
                                        <input type="text" class="form-control" id="total_harga" value="Rp {{ number_format($rs->total_harga, 0, ',', '.') }}" readonly>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit -->
                    <div class="modal fade" id="editTransactionModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="editTransactionModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editTransactionModalLabel{{ $rs->id }}">Ubah Data Obat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('transactions.update', $rs->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="tanggal">Tanggal Transaksi</label>
                                            <input type="text" class="form-control" id="tanggal" value="{{ $rs->created_at->format('d-m-Y') }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="id_transaksi">ID Transaksi</label>
                                            <input type="text" class="form-control" id="id_transaksi" value="{{ $rs->transaksi_id }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_produk">Nama Produk</label>
                                            <input type="text" class="form-control" id="nama_produk" 
                                                value="{{ $rs->medicine ? $rs->medicine->nama_obat : $rs->medicinedevice->nama_alatkesehatan }}" 
                                                readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="stok">Stok</label>
                                            <input type="text" class="form-control" id="stok" 
                                                value="{{ $rs->medicine ? $rs->medicine->stok : $rs->medicinedevice->stok }}" 
                                                readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="harga">Harga</label>
                                            <input type="text" class="form-control" id="harga" 
                                                value="Rp {{ number_format($rs->medicine ? $rs->medicine->harga : $rs->medicinedevice->harga, 0, ',', '.') }}" 
                                                readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status">Status Transaksi :</label>
                                            @if ($rs->status === 'buy')
                                                <span class="badge bg-success">BELI</span>
                                            @elseif ($rs->status === 'sale')
                                                <span class="badge bg-warning">JUAL</span>
                                            @else
                                                <span class="badge bg-secondary">UNKNOWN</span>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label for="jumlah">Jumlah</label>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" 
                                                value="{{ $rs->jumlah }}" min="1" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="total_harga">Total Harga</label>
                                            <input type="text" class="form-control" id="total_harga" 
                                                value="Rp {{ number_format($rs->total_harga, 0, ',', '.') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete -->
                    <div class="modal fade" id="deleteTransactionModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteTransactionModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteTransactionModalLabel{{ $rs->id }}">Hapus Data Transaksi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('transactions.destroy', $rs->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus data transaksi berikut?</p>
                                    <p><strong>
                                        Tanggal Transaksi : {{ $rs->tanggal_transaksi }}<br>
                                        ID Transaksi : {{ $rs->transaksi_id }}<br>
                                        Nama Produk : {{ $rs->medicine ? $rs->medicine->nama_obat : $rs->medicinedevice->nama_alatkesehatan }}<br>
                                        Status Transaksi : 
                                        @if ($rs->status === 'buy')
                                            <span class="badge bg-success">BELI</span>
                                        @elseif ($rs->status === 'sale')
                                            <span class="badge bg-warning">JUAL</span>
                                        @endif
                                    </strong></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Create -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" role="dialog" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Tambah Data Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal_transaksi">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status">Status Transaksi</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">-- Pilih Status Transaksi --</option>
                            <option value="buy">Beli</option>
                            <option value="sale">Jual</option>
                        </select>
                    </div>
                    <div id="transactionItemsContainer" style="display: none;">
                        <div id="transactionItems">
                            <div class="transaction-item">
                                <div class="row">
                                    <!-- Pilih Obat -->
                                    <div class="col-md-7 mb-3">
                                        <label for="medicine_id">Pilih Obat</label>
                                        <select name="medicine_id[]" id="medicine_id" class="form-control">
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach($medicines as $medicine)
                                                <option value="{{ $medicine->id }}">{{ $medicine->nama_obat }} - Stok: {{ $medicine->stok }} - Harga: {{ $medicine->harga }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Jumlah Obat -->
                                    <div class="col-md-5 mb-3">
                                        <label for="jumlah">Jumlah Obat</label>
                                        <input type="number" name="jumlah[]" id="jumlah" class="form-control" min="1">
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Pilih Alat Kesehatan -->
                                    <div class="col-md-7 mb-3">
                                        <label for="medicinedevice_id">Pilih Alat Kesehatan</label>
                                        <select name="medicinedevice_id[]" id="medicinedevice_id" class="form-control">
                                            <option value="">-- Pilih Alat Kesehatan --</option>
                                            @foreach($medicinedevices as $device)
                                                <option value="{{ $device->id }}">{{ $device->nama_alatkesehatan }} - Stok: {{ $device->stok }} - Harga: {{ $device->harga }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Jumlah Alat Kesehatan -->
                                    <div class="col-md-5 mb-3">
                                        <label for="jumlah_device">Jumlah Alat Kesehatan</label>
                                        <input type="number" name="jumlah_device[]" id="jumlah_device" class="form-control" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Tambah Barang -->
                        <button type="button" class="btn btn-success" id="addTransactionItem">Tambah Barang</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Tampilkan form barang setelah status dipilih
    document.getElementById('status').addEventListener('change', function () {
        const transactionItemsContainer = document.getElementById('transactionItemsContainer');
        if (this.value) {
            transactionItemsContainer.style.display = 'block';
        } else {
            transactionItemsContainer.style.display = 'none';
        }
    });

    // Tambahkan barang baru
    document.getElementById('addTransactionItem').addEventListener('click', function () {
        const transactionItem = document.querySelector('.transaction-item').cloneNode(true);
        transactionItem.querySelectorAll('input, select').forEach((element) => {
            element.value = ''; // Clear input values
        });
        document.getElementById('transactionItems').appendChild(transactionItem);
    });
</script>



<script>
    function showSearchButton() {
        const typeSelect = document.getElementById('type');
        const searchButton = document.getElementById('search-button');
        
        // Menampilkan tombol Cari jika jenis produk adalah Obat
        if (typeSelect.value === 'medicine') {
            searchButton.style.display = 'block';
        } else {
            searchButton.style.display = 'none';
        }
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(Session::has('success'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif
    });
</script>


@endsection
