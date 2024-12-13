<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\MedicineDevice;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use Yajra\DataTables\DataTables;
use App\Models\transaction;

class ReportController extends Controller
{
    public function indexMedicine(Request $request)
    {
        if ($request->ajax()) {
            $medicines = Medicine::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();
            return DataTables::of($medicines)
                ->make(true);
        }
        
        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        $medicines = Medicine::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();

        return view('medicines.report', compact('medicines', 'categories', 'satuans', 'suppliers'));
    }

    public function indexMedicineDevice(Request $request)
    {
        if ($request->ajax()) {
            $medicinedevices = Medicine::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();
            return DataTables::of($medicinedevices)
                ->make(true);
        }
        
        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        $medicinedevices = MedicineDevice::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();

        return view('medicinedevices.report', compact('medicinedevices', 'categories', 'satuans', 'suppliers'));
    }

    public function indexTransaction(Request $request)
    {
        $query = transaction::with(['medicine', 'medicinedevice'])->orderBy('created_at', 'DESC');
    
        if ($request->filled('tanggal_masuk') && $request->filled('tanggal_keluar')) {
            $tanggalMasuk = $request->input('tanggal_masuk');
            $tanggalKeluar = $request->input('tanggal_keluar');
            
            $query->whereBetween('tanggal_transaksi', [$tanggalMasuk, $tanggalKeluar]);
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $status = $request->input('status');
            $query->where('status', $status);
        }
    
        if ($request->ajax()) {
            return DataTables::of($query)->make(true);
        }
    
        $medicines = Medicine::all();
        $medicinedevices = MedicineDevice::all();
        $transactions = $query->get();
    
        return view('transactions.report', compact('transactions', 'medicines', 'medicinedevices'));
    }
    
}
