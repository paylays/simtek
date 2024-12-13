<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\transaction;
use App\Models\Medicine;
use App\Models\MedicineDevice;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung stok obat dan alat kesehatan
        $stokObat = Medicine::sum('stok');
        $stokAlatKesehatan = MedicineDevice::sum('stok');
        
        // Hitung total pembelian dan penjualan minggu ini
        $startDate = Carbon::today()->subDays(6);
        $endDate = Carbon::today();
        
        $pembelianMingguIni = transaction::whereBetween('tanggal_transaksi', [$startDate, $endDate])
        ->where('status', 'buy')
        ->sum('total_harga');
    
        $penjualanMingguIni = transaction::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'sale')
            ->sum('total_harga');
        
        // Ambil data untuk chart 7 hari terakhir
        $labels = [];
        $pembelianData = [];
        $penjualanData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');
            
            $pembelianData[] = transaction::whereDate('tanggal_transaksi', $date)
                ->where('status', 'buy')
                ->sum('total_harga');
            
            $penjualanData[] = transaction::whereDate('tanggal_transaksi', $date)
                ->where('status', 'sale')
                ->sum('total_harga');
        }
        
        // Hitung total pembelian dan penjualan per bulan
        $pembelianPerBulan = transaction::selectRaw('YEAR(tanggal_transaksi) as tahun, MONTH(tanggal_transaksi) as bulan, SUM(total_harga) as total')
            ->where('status', 'buy')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan')
            ->get();
        
        $penjualanPerBulan = transaction::selectRaw('YEAR(tanggal_transaksi) as tahun, MONTH(tanggal_transaksi) as bulan, SUM(total_harga) as total')
            ->where('status', 'sale')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan')
            ->get();
        
        // Siapkan data untuk bar chart
        $totalPembelian = array_fill(1, 12, 0); // Inisialisasi array dengan 12 elemen bernilai 0
        $totalPenjualan = array_fill(1, 12, 0);
        
        foreach ($pembelianPerBulan as $item) {
            $totalPembelian[$item->bulan] = $item->total;
        }
        
        foreach ($penjualanPerBulan as $item) {
            $totalPenjualan[$item->bulan] = $item->total;
        }
        
        // Konversi data ke array untuk Chart.js
        $labelsBulan = [];
        $currentYear = Carbon::now()->year;
        
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::createFromDate($currentYear, $i + 1, 1);
            $labelsBulan[] = $month->format('M Y');
        }
        
        $totalPembelianData = array_values($totalPembelian);
        $totalPenjualanData = array_values($totalPenjualan);
        
        // Kirim data ke view
        return view('dashboard', compact(
            'stokObat',
            'stokAlatKesehatan',
            'pembelianMingguIni',
            'penjualanMingguIni',
            'labels',
            'pembelianData',
            'penjualanData',
            'labelsBulan',
            'totalPembelianData',
            'totalPenjualanData'
        ));
    }
}
