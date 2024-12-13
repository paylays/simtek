@extends('layouts.app')

@section('title', 'SIMTEK | Laporan Transaksi')

@section('content')

<h1 class="mt-4">Laporan Data Transaksi</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Data Transaksi</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        <span class="me-2">Data Transaksi</span>
        <a href="{{ route('viewexportstransaction.download', [
            'tanggal_masuk' => request('tanggal_masuk'),
            'tanggal_keluar' => request('tanggal_keluar'),
            'status' => request('status')
        ]) }}" class="btn btn-danger float-end me-2">
            <i class="fas fa-file-pdf me-1"></i> Export PDF
        </a>
        <a href="{{ route('viewexportstransaction.view', [
            'tanggal_masuk' => request('tanggal_masuk'),
            'tanggal_keluar' => request('tanggal_keluar'),
            'status' => request('status')
        ]) }}"  target="_blank" class="btn btn-info float-end me-2">
            <i class="fas fa-eye me-1"></i> View PDF    
        </a>
    </div>
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="card-body">
        <form method="GET" action="{{ route('reportstransaction') }}" class="row mb-3">
            <div class="col-md-3">
                <label for="tanggal_masuk">Tanggal Masuk:</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="tanggal_keluar">Tanggal Keluar:</label>
                <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="status">Status Transaksi:</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="buy">Beli</option> 
                    <option value="sale">Jual</option>
                </select>
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Sortir</button>
                <a href="{{ route('reportstransaction') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>ID Transaksi</th>
                    <th>Nama Produk</th>
                    <th>Status Transaksi</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
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
                        <td>Rp {{ number_format($rs->total_harga, 0, ',', '.') }}</td>
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
