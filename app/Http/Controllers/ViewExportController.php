<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\MedicineDevice;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\transaction;
use Carbon\Carbon;

class ViewExportController extends Controller
{
    public function indexMedicine(Request $request)
    {   
        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        $currentDate = Carbon::now()->locale('id_ID')->translatedFormat('l, j F Y');

        $medicines = Medicine::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();

        return view('medicines.viewexport', compact('medicines', 'categories', 'satuans', 'suppliers', 'currentDate'));
    }

    public function viewPdfMedicine() 
    {
        $mpdf = new \Mpdf\Mpdf();

        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        $currentDate = Carbon::now()->locale('id_ID')->translatedFormat('l, j F Y');

        $medicines = Medicine::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();

        $mpdf->WriteHTML(view('medicines.viewexport', compact('medicines', 'categories', 'satuans', 'suppliers', 'currentDate')));
        $mpdf->Output();
    }

    public function downloadPdfMedicine() 
    {
        $mpdf = new \Mpdf\Mpdf();

        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 
        
        $currentDate = Carbon::now()->locale('id_ID')->translatedFormat('l, j F Y');

        $medicines = Medicine::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();

        $mpdf->WriteHTML(view('medicines.viewexport', compact('medicines', 'categories', 'satuans', 'suppliers', 'currentDate')));
        $mpdf->Output('download_pdf_obat.pdf','D');
    }

    public function indexMedicineDevice(Request $request)
    {   
        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        $currentDate = Carbon::now()->locale('id_ID')->translatedFormat('l, j F Y');

        $medicinedevices = MedicineDevice::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();

        return view('medicinedevices.viewexport', compact('medicinedevices', 'categories', 'satuans', 'suppliers', 'currentDate'));
    }

    public function viewPdfMedicineDevice() 
    {
        $mpdf = new \Mpdf\Mpdf();

        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        $currentDate = Carbon::now()->locale('id_ID')->translatedFormat('l, j F Y');

        $medicinedevices = MedicineDevice::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();

        $mpdf->WriteHTML(view('medicinedevices.viewexport', compact('medicinedevices', 'categories', 'satuans', 'suppliers', 'currentDate')));
        $mpdf->Output();
    }

    public function downloadPdfMedicineDevice() 
    {
        $mpdf = new \Mpdf\Mpdf();

        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        $currentDate = Carbon::now()->locale('id_ID')->translatedFormat('l, j F Y');

        $medicinedevices = MedicineDevice::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();

        $mpdf->WriteHTML(view('medicinedevices.viewexport', compact('medicinedevices', 'categories', 'satuans', 'suppliers', 'currentDate')));
        $mpdf->Output('download_pdf_alat_kesehatan.pdf','D');
    }
    
    public function indexTransaction(Request $request)
    {   
        $query = transaction::with(['medicine', 'medicinedevice'])->orderBy('created_at', 'DESC');

        $tanggalMasuk = $request->input('tanggal_masuk');
        $tanggalKeluar = $request->input('tanggal_keluar');
    
        if ($request->filled('tanggal_masuk') && $request->filled('tanggal_keluar')) {
            $tanggalMasuk = $request->input('tanggal_masuk');
            $tanggalKeluar = $request->input('tanggal_keluar');
            
            $query->whereBetween('tanggal_transaksi', [$tanggalMasuk, $tanggalKeluar]);
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        $transactions = $query->get();

        if ($transactions->isEmpty()) {
            $tanggalMasuk = null;
            $tanggalKeluar = null;
        } else {
            $tanggalMasuk = $transactions->min('tanggal_transaksi');
            $tanggalKeluar = $transactions->max('tanggal_transaksi');
        }

        $medicines = Medicine::all();
        $medicinedevices = MedicineDevice::all();

        return view('transactions.viewexport', compact('transactions', 'medicines', 'medicinedevices', 'tanggalMasuk', 'tanggalKeluar'));
    }

    public function viewPdfTransaction(Request $request) 
    {
        $mpdf = new \Mpdf\Mpdf();

        $query = transaction::with(['medicine', 'medicinedevice'])->orderBy('created_at', 'DESC');

        $tanggalMasuk = $request->input('tanggal_masuk');
        $tanggalKeluar = $request->input('tanggal_keluar');
    
        if ($request->filled('tanggal_masuk') && $request->filled('tanggal_keluar')) {
            $tanggalMasuk = $request->input('tanggal_masuk');
            $tanggalKeluar = $request->input('tanggal_keluar');
            
            $query->whereBetween('tanggal_transaksi', [$tanggalMasuk, $tanggalKeluar]);
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        $transactions = $query->get();

        if ($transactions->isEmpty()) {
            $tanggalMasuk = null;
            $tanggalKeluar = null;
        } else {
            $tanggalMasuk = $transactions->min('tanggal_transaksi');
            $tanggalKeluar = $transactions->max('tanggal_transaksi');
        }

        $medicines = Medicine::all();
        $medicinedevices = MedicineDevice::all();
        
        $mpdf->WriteHTML(view('transactions.viewexport', compact('transactions', 'medicines', 'medicinedevices', 'tanggalMasuk', 'tanggalKeluar')));
        $mpdf->Output();
    }

    public function downloadPdfTransaction(Request $request) : void
    {
        $mpdf = new \Mpdf\Mpdf();
        
        $query = transaction::with(['medicine', 'medicinedevice'])->orderBy('created_at', 'DESC');
    
        $tanggalMasuk = $request->input('tanggal_masuk');
        $tanggalKeluar = $request->input('tanggal_keluar');
        
        if ($request->filled('tanggal_masuk') && $request->filled('tanggal_keluar')) {
            $tanggalMasuk = $request->input('tanggal_masuk');
            $tanggalKeluar = $request->input('tanggal_keluar');
            
            $query->whereBetween('tanggal_transaksi', [$tanggalMasuk, $tanggalKeluar]);
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        $transactions = $query->get();

        if ($transactions->isEmpty()) {
            $tanggalMasuk = null;
            $tanggalKeluar = null;
        } else {
            $tanggalMasuk = $transactions->min('tanggal_transaksi');
            $tanggalKeluar = $transactions->max('tanggal_transaksi');
        }

        $medicines = Medicine::all();
        $medicinedevices = MedicineDevice::all();
        
        $mpdf->WriteHTML(view('transactions.viewexport', compact('transactions', 'medicines', 'medicinedevices', 'tanggalMasuk', 'tanggalKeluar')));
        $mpdf->Output('download_pdf_transaksi.pdf','D');
    }

}
