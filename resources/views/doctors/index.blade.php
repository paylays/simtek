@extends('layouts.app')

@section('title', 'SIMTEK | Data Dokter')

@section('content')

<h1 class="mt-4">Data Dokter</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Dokter</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Data Dokter
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
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
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('doctors') }}'">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Nama Dokter</th>
                    <th>Spesialis</th>
                    <th>Nomor Hp</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors as $rs)
                    <tr>
                        <td>{{ $rs->nama_dokter }}</td>
                        <td>
                            @if ($rs->spesialis == 'UMUM')
                                <span class="badge bg-success">Umum</span>
                            @else
                                {{ $rs->spesialis }}
                            @endif
                        </td>
                        <td>{{ $rs->nomor_hp }}</td>
                        <td>{{ $rs->email }}</td>
                        <td>{{ $rs->alamat }}</td>
                        <td>
                            <div aria-label="Basic example">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" id="actionButton{{ $rs->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="actionButton{{ $rs->id }}">
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#showDoctorModal{{ $rs->id }}">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#editDoctorModal{{ $rs->id }}">
                                        <i class="fas fa-edit"></i> Ubah
                                    </button>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#deleteDoctorModal{{ $rs->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Detail -->
                    <div class="modal fade" id="showDoctorModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="showDoctorModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showDoctorModalLabel{{ $rs->id }}">Detail Data Dokter</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nama_dokter" class="form-label">Nama Dokter</label>
                                        <input type="text" class="form-control" id="nama_dokter" value="{{ $rs->nama_dokter }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="spesialis" class="form-label">Spesialis</label>
                                        <input type="text" class="form-control" id="spesialis" value="{{ $rs->spesialis }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_hp" class="form-label">Nomor Hp</label>
                                        <input type="text" class="form-control" id="nomor_hp" value="{{ $rs->nomor_hp }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" value="{{ $rs->email }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" value="{{ $rs->alamat }}" readonly>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit  -->
                    <div class="modal fade" id="editDoctorModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editDoctorModalLabel{{ $rs->id }}">Ubah Data Dokter</h5>
                                    <button type="button" class="btn-close" id="closeModalButtonCreate" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('doctors.update', $rs->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama_dokter" class="form-label">Nama Dokter</label>
                                            <input type="text" class="form-control @error('nama_dokter') is-invalid @enderror" id="nama_dokter" name="nama_dokter" value="{{ $rs->nama_dokter }}">
                                            @error('nama_dokter')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="spesialis" class="form-label">Spesialis</label>
                                            <select class="form-control @error('spesialis') is-invalid @enderror" id="spesialis" name="spesialis">
                                                <option value="Umum" {{ old('spesialis', $rs->spesialis) == 'Umum' ? 'selected' : '' }}>Umum</option>
                                            </select>
                                            @error('spesialis')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="nomor_hp" class="form-label">Nomor Hp</label>
                                            <input type="number" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ $rs->nomor_hp }}">
                                            @error('nomor_hp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $rs->email }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat">{{ $rs->alamat }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
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
                    <div class="modal fade" id="deleteDoctorModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteDoctorModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteDoctorModalLabel{{ $rs->id }}">Hapus Data Dokter</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('doctors.destroy', $rs->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus data dokter <strong>{{ $rs->nama_dokter }}</strong>?</p>
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
<div class="modal fade" id="addDoctorModal" tabindex="-1" role="dialog" aria-labelledby="addDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDoctorModalLabel">Tambah Data Dokter</h5>
                <button type="button" class="btn-close" id="closeModalButtonCreate" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('doctors.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_dokter" class="form-label">Nama Dokter</label>
                        <input type="text" class="form-control @error('nama_dokter') is-invalid @enderror" id="nama_dokter" name="nama_dokter" value="{{ old('nama_dokter') }}">
                        @error('nama_dokter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="spesialis" class="form-label">Spesialis</label>
                        <select class="form-control @error('spesialis') is-invalid @enderror" id="spesialis" name="spesialis">
                            <option value="UMUM" {{ old('spesialis', 'UMUM') == 'UMUM' ? 'selected' : '' }}>UMUM</option>
                        </select>
                        @error('spesialis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nomor_hp" class="form-label">Nomor Hp</label>
                        <input type="number" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}">
                        @error('nomor_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
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
        var addDoctorModal = new bootstrap.Modal(document.getElementById('addDoctorModal'));

        // Tampilkan modal saat ada error
        addDoctorModal.show();
    });
</script>
@endif

<script>
    // Event listener untuk modal create
    document.getElementById('addDoctorModal').addEventListener('hidden.bs.modal', function () {
        // Refresh halaman setelah modal ditutup
        window.location.reload();
    });

    // Event listener untuk modal edit
    document.querySelectorAll('[id^="editDoctorModal"]').forEach(modal => {
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
