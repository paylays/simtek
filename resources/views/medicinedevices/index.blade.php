@extends('layouts.app')

@section('title', 'SIMTEK | Data Alat Kesehatan')

@section('content')

<h1 class="mt-4">Data Alat Kesehatan</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Alat Kesehatan</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        <span class="me-2">Data Alat Kesehatan</span>
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addMedicineDeviceModal">
            <i class="fas fa-plus me-1"></i> Tambah Data
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
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('medicinedevices') }}'">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Kategori</th>
                    <th>Nama Alat Kesehatan</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Keterangan</th>
                    <th>Supplier</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicinedevices as $rs)
                    <tr>
                        <td>{{ $rs->kode_produk }}</td>
                        <td>{{ $rs->kategori->nama_kategori }}</td>
                        <td>{{ $rs->nama_alatkesehatan }}</td>
                        <td>{{ $rs->stok }}</td>
                        <td>{{ $rs->satuan->nama_satuan }}</td>
                        <td>Rp {{ number_format($rs->harga, 0, ',', '.') }}</td>
                        <td>{{ $rs->keterangan }}</td>
                        <td>{{ $rs->suplier->nama_suplier }}</td>
                        <td>
                            <div aria-label="Basic example">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" id="actionButton{{ $rs->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="actionButton{{ $rs->id }}">
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#showMedicineDeviceModal{{ $rs->id }}">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#editMedicineDeviceModal{{ $rs->id }}">
                                        <i class="fas fa-edit"></i> Ubah
                                    </button>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#deleteMedicineDeviceModal{{ $rs->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Detail -->
                    <div class="modal fade" id="showMedicineDeviceModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="showMedicineDeviceModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showMedicineDeviceModalLabel{{ $rs->id }}">Detail Data Alat Kesehatan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="kategori">Kategori</label>
                                        <input type="text" class="form-control" id="kategori" value="{{ $rs->kategori->nama_kategori }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_alatkesehatan">Nama Alat Kesehatan</label>
                                        <input type="text" class="form-control" id="nama_alatkesehatan" value="{{ $rs->nama_alatkesehatan }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stok">Stok</label>
                                        <input type="text" class="form-control" id="stok" value="{{ $rs->stok }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="satuan">Satuan</label>
                                        <input type="text" class="form-control" id="satuan" value="{{ $rs->satuan->nama_satuan }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="harga">Harga</label>
                                        <input type="text" class="form-control" id="harga" value="{{ $rs->harga }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" readonly>{{ $rs->keterangan }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="suplier">Supplier</label>
                                        <input type="text" class="form-control" id="suplier" value="{{ $rs->suplier->nama_suplier }}" readonly>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hapus  -->
                    <div class="modal fade" id="editMedicineDeviceModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="editMedicineDeviceModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editMedicineDeviceModalLabel{{ $rs->id }}">Ubah Data Alat Kesehatan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('medicinedevices.update', $rs->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="kategori_id" class="form-label">Kategori</label>
                                            <select name="kategori_id" id="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $rs->kategori_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->nama_kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kategori_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_alatkesehatan" class="form-label">Nama Obat</label>
                                            <input type="text" class="form-control @error('nama_alatkesehatan') is-invalid @enderror" name="nama_alatkesehatan" value="{{ $rs->nama_alatkesehatan }}">
                                            @error('nama_alatkesehatan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="stok" class="form-label">Stok</label>
                                            <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ $rs->stok }}">
                                            @error('stok')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="satuan_id" class="form-label">Satuan</label>
                                            <select name="satuan_id" id="satuan_id" class="form-control @error('satuan_id') is-invalid @enderror">
                                                @foreach($satuans as $unit)
                                                    <option value="{{ $unit->id }}" {{ $rs->satuan_id == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->nama_satuan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('satuan_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="harga" class="form-label">Harga</label>
                                            <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ $rs->harga }}">
                                            @error('harga')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan">{{ $rs->keterangan }}</textarea>
                                            @error('keterangan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="suplier_id" class="form-label">Supplier</label>
                                            <select name="suplier_id" id="suplier_id" class="form-control @error('suplier_id') is-invalid @enderror">
                                                @foreach($suppliers as $unit)
                                                    <option value="{{ $unit->id }}" {{ $rs->suplier_id == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->nama_suplier }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('suplier_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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
                    <div class="modal fade" id="deleteMedicineDeviceModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteMedicineDeviceModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteMedicineDeviceModalLabel{{ $rs->id }}">Hapus Data Alat Kesehatan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('medicinedevices.destroy', $rs->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus data alatkesehatan <strong>{{ $rs->nama_alatkesehatan }}</strong>?</p>
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
<div class="modal fade" id="addMedicineDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addMedicineDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMedicineDeviceModalLabel">Tambah Data Alat Kesehatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('medicinedevices.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_alatkesehatan" class="form-label">Nama Obat</label>
                        <input type="text" class="form-control @error('nama_alatkesehatan') is-invalid @enderror" name="nama_alatkesehatan" value="{{ old('nama_alatkesehatan') }}">
                        @error('nama_alatkesehatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ old('stok') }}">
                        @error('stok')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="satuan_id" class="form-label">Satuan</label>
                        <select name="satuan_id" id="satuan_id" class="form-control @error('satuan_id') is-invalid @enderror">
                            @foreach($satuans as $unit)
                                <option value="{{ $unit->id }}" {{ old('satuan_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama_satuan }}
                                </option>
                            @endforeach
                        </select>
                        @error('satuan_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga') }}">
                        @error('harga')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="suplier_id" class="form-label">Supplier</label>
                        <select name="suplier_id" id="suplier_id" class="form-control @error('suplier_id') is-invalid @enderror">
                            @foreach($suppliers as $unit)
                                <option value="{{ $unit->id }}" {{ old('suplier_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama_suplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('suplier_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var addMedicineDeviceModal = new bootstrap.Modal(document.getElementById('addMedicineDeviceModal'));

        // Tampilkan modal saat ada error
        addMedicineDeviceModal.show();
    });
</script>
@endif

<script>
    // Event listener untuk modal create
    document.getElementById('addMedicineDeviceModal').addEventListener('hidden.bs.modal', function () {
        // Refresh halaman setelah modal ditutup
        window.location.reload();
    });

    // Event listener untuk modal edit
    document.querySelectorAll('[id^="editMedicineDeviceModal"]').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', function () {
            // Refresh halaman setelah modal ditutup
            window.location.reload();
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#datatablesSimple').DataTable({
            paging: true,
            searching: true,
            ordering: true,
        });
    });
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
