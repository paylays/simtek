@extends('layouts.app')

@section('title', 'SIMTEK | Data Pasien')

@section('content')

<h1 class="mt-4">Data Pasien</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Pasien</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Data Pasien
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addPatientModal">
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
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('patients') }}'">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Nama Pasien</th>
                    <th>Usia</th>
                    <th>Nomor Hp</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $rs)
                    <tr>
                        <td>{{ $rs->nama_pasien }}</td>
                        <td>{{ $rs->umur }} Tahun</td>
                        <td>{{ $rs->nomor_hp }}</td>
                        <td>{{ $rs->alamat }}</td>
                        <td>
                            <div aria-label="Basic example">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" id="actionButton{{ $rs->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="actionButton{{ $rs->id }}">
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#showPatientModal{{ $rs->id }}">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#editPatientModal{{ $rs->id }}">
                                        <i class="fas fa-edit"></i> Ubah
                                    </button>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#deletePatientModal{{ $rs->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Detail -->
                    <div class="modal fade" id="showPatientModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="showPatientModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showPatientModalLabel{{ $rs->id }}">Detail Data Pasien</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                        <input type="text" class="form-control" id="nama_pasien" value="{{ $rs->nama_pasien }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="umur" class="form-label">Usia</label>
                                        <input type="number" class="form-control" id="umur" value="{{ $rs->umur }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_hp" class="form-label">Nomor Hp</label>
                                        <input type="text" class="form-control" id="nomor_hp" value="{{ $rs->nomor_hp }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea type="text" class="form-control" id="alamat" readonly>{{ $rs->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit  -->
                    <div class="modal fade" id="editPatientModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPatientModalLabel{{ $rs->id }}">Ubah Data Pasien</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('patients.update', $rs->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                            <input type="text" class="form-control @error('nama_pasien') is-invalid @enderror" id="nama_pasien" name="nama_pasien" value="{{ $rs->nama_pasien }}">
                                            @error('nama_pasien')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="umur" class="form-label">Usia</label>
                                            <input type="number" class="form-control @error('umur') is-invalid @enderror" id="umur" name="umur" value="{{ $rs->umur }}">
                                            @error('umur')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="nomor_hp" class="form-label">Nomor Hp</label>
                                            <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ $rs->nomor_hp }}">
                                            @error('nomor_hp')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat">{{ $rs->alamat }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" id="closeModalButtonEdit" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete -->
                    <div class="modal fade" id="deletePatientModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="deletePatientModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deletePatientModalLabel{{ $rs->id }}">Hapus Data Pasien</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('patients.destroy', $rs->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus data pasien <strong>{{ $rs->nama_pasien }}</strong>?</p>
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
<div class="modal fade" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientModalLabel">Tambah Data Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('patients.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_pasien" class="form-label">Nama Pasien</label>
                        <input type="text" class="form-control @error('nama_pasien') is-invalid @enderror" id="nama_pasien" name="nama_pasien" value="{{ old('nama_pasien') }}">
                        @error('nama_pasien')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="umur" class="form-label">Usia</label>
                        <input type="number" class="form-control @error('umur') is-invalid @enderror" id="umur" name="umur" value="{{ old('umur') }}">
                        @error('umur')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nomor_hp" class="form-label">Nomor Hp</label>
                        <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}">
                        @error('nomor_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalButtonCreate" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var addPatientModal = new bootstrap.Modal(document.getElementById('addPatientModal'));

        // Tampilkan modal saat ada error
        addPatientModal.show();
    });
</script>
@endif

<script>
    // Event listener untuk modal create
    document.getElementById('addPatientModal').addEventListener('hidden.bs.modal', function () {
        // Refresh halaman setelah modal ditutup
        window.location.reload();
    });

    // Event listener untuk modal edit
    document.querySelectorAll('[id^="editPatientModal"]').forEach(modal => {
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
