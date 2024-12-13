<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Laporan Transaksi</title>
    <style>
        table {
            border: 1px solid #ddd;
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) { background-color: #f2f2f2; }

        th {
            background-color: #005b8f;
            color: white;
        }

        /* Gaya untuk judul */
        .title-container {
            text-align: center;
            margin-bottom: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 16px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title-container">
            <p class="title">Laporan Data Transaksi</p>
            <p class="subtitle">Apotek Maharani Kimia Farma</p>
            <p>Periode: {{ $tanggalMasuk ? \Carbon\Carbon::parse($tanggalMasuk)->format('d M Y') : 'Tidak ditentukan' }} s/d {{ $tanggalKeluar ? \Carbon\Carbon::parse($tanggalKeluar)->format('d M Y') : 'Tidak ditentukan' }}</p>
        </div>
            
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>ID Transaksi</th>
                    <th>Nama Produk</th>
                    <th>Status</th>
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
</body>
</html>