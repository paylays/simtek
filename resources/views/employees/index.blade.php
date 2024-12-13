@extends('layouts.app')

@section('title', 'SIMTEK | Data Karyawan')

@section('content')

<h1 class="mt-4">Data Karyawan</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Karyawan</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Data Karyawan
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
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
                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('employees') }}'">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Posisi</th>
                    <th>Usia</th>
                    <th>Nomor Hp</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $rs)
                    <tr>
                        <td>{{ $rs->nama_karyawan }}</td>
                        <td>
                            @if ($rs->posisi == 'ADMIN')
                                <span class="badge bg-primary">Admin</span>
                            @elseif ($rs->posisi == 'PEMILIK')
                                <span class="badge bg-success">Pemilik</span>
                            @else
                                {{ $rs->posisi }}
                            @endif
                        </td>
                        <td>{{ $rs->umur }} Tahun</td>
                        <td>{{ $rs->nomor_hp }}</td>
                        <td>{{ $rs->email }}</td>
                        <td>{{ $rs->alamat }}</td>
                        <td>
                            <div aria-label="Basic example">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" id="actionButton{{ $rs->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="actionButton{{ $rs->id }}">
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#showEmployeeModal{{ $rs->id }}">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#editEmployeeModal{{ $rs->id }}">
                                        <i class="fas fa-edit"></i> Ubah
                                    </button>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal{{ $rs->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Detail -->
                    <div class="modal fade" id="showEmployeeModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="showEmployeeModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="showEmployeeModalLabel{{ $rs->id }}">Detail Data Karyawan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                        <input type="text" class="form-control" id="nama_karyawan" value="{{ $rs->nama_karyawan }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="posisi" class="form-label">Posisi</label>
                                        <input type="text" class="form-control" id="posisi" value="{{ $rs->posisi }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="umur" class="form-label">Usia</label>
                                        <input type="text" class="form-control" id="umur" value="{{ $rs->umur }}" readonly>
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
                    <div class="modal fade" id="editEmployeeModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editEmployeeModalLabel{{ $rs->id }}">Ubah Data Karyawan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('employees.update', $rs->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                            <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror" id="nama_karyawan" name="nama_karyawan" value="{{ $rs->nama_karyawan }}" >
                                            @error('nama_karyawan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="posisi" class="form-label">Posisi</label>
                                            <select name="posisi" class="form-control @error('posisi') is-invalid @enderror" >
                                                <option value="admin" {{ old('posisi') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="pemilik" {{ old('posisi') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                                            </select>
                                            @error('posisi')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="umur" class="form-label">Usia</label>
                                            <input type="text" class="form-control @error('umur') is-invalid @enderror" id="umur" name="umur" value="{{ $rs->umur }}" >
                                            @error('umur')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="nomor_hp" class="form-label">Nomor Hp</label>
                                            <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ $rs->nomor_hp }}" >
                                            @error('nomor_hp')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $rs->email }}" >
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat">{{ $rs->alamat }}</textarea>
                                            @error('alamat')
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
                    <div class="modal fade" id="deleteEmployeeModal{{ $rs->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteEmployeeModalLabel{{ $rs->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteEmployeeModalLabel{{ $rs->id }}">Hapus Data Karyawan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('employees.destroy', $rs->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus data karyawan <strong>{{ $rs->nama_karyawan }}</strong>?</p>
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
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Tambah Data Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('employees.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control @error('nama_karyawan') is-invalid @enderror" id="nama_karyawan" name="nama_karyawan" value="{{ old('nama_karyawan') }}" >
                        @error('nama_karyawan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="posisi" class="form-label">Posisi</label>
                        <select name="posisi" class="form-control @error('posisi') is-invalid @enderror" >
                            <option value="admin" {{ old('posisi') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pemilik" {{ old('posisi') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                        </select>
                        @error('posisi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="umur" class="form-label">Usia</label>
                        <input type="text" class="form-control @error('umur') is-invalid @enderror" id="umur" name="umur" value="{{ old('umur') }}" >
                        @error('umur')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nomor_hp" class="form-label">Nomor Hp</label>
                        <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" >
                        @error('nomor_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}" ></textarea>
                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalButton" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var addEmployeeModal = new bootstrap.Modal(document.getElementById('addEmployeeModal'));

        // Tampilkan modal saat ada error
        addEmployeeModal.show();
    });
</script>
@endif

<script>
    // Event listener untuk modal create
    document.getElementById('addEmployeeModal').addEventListener('hidden.bs.modal', function () {
        // Refresh halaman setelah modal ditutup
        window.location.reload();
    });

    // Event listener untuk modal edit
    document.querySelectorAll('[id^="editEmployeeModal"]').forEach(modal => {
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
