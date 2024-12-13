@extends('layouts.app')

@section('title', 'SIMTEK | Laporan Obat')

@section('content')

<h1 class="mt-4">Laporan Data Obat</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Data Obat</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        <span class="me-2">Data Obat</span>
        <a href="{{ route('viewexportsmedicine.download') }}" class="btn btn-danger float-end me-2">
            <i class="fas fa-file-pdf me-1"></i> Export PDF
        </a>
        <a href="{{ route('viewexportsmedicine.view') }}" target="_blank" class="btn btn-info float-end me-2">
            <i class="fas fa-eye me-1"></i> View PDF    
        </a>
    </div>
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Kategori</th>
                    <th>Nama Obat</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Keterangan</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicines as $rs)
                    <tr>
                        <td>{{ $rs->kode_produk }}</td>
                        <td>{{ $rs->kategori->nama_kategori }}</td>
                        <td>{{ $rs->nama_obat }}</td>
                        <td>{{ $rs->stok }}</td>
                        <td>{{ $rs->satuan->nama_satuan }}</td>
                        <td>Rp {{ number_format($rs->harga, 0, ',', '.') }}</td>
                        <td>{{ $rs->keterangan }}</td>
                        <td>{{ $rs->suplier->nama_suplier }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#datatablesSimple').DataTable({
            paging: true,
            searching: true,
            ordering: true,
        });
    });
</script>

@endsection
