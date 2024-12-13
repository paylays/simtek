<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Laporan Alat Kesehatan</title>
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
            <p class="title">Laporan Data Alat Kesehatan</p>
            <p class="subtitle">Apotek Maharani Kimia Farma</p>
            <p>Tanggal Cetak : {{ $currentDate }}</p>
        </div>
        <table class="table">
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>