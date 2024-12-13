<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaction;
use App\Models\Medicine;
use App\Models\MedicineDevice;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $transactions = transaction::with(['medicine', 'medicinedevice'])->orderBy('tanggal_transaksi', 'DESC')->get();
            return DataTables::of($transactions)
                ->make(true);
        }

        $medicines = Medicine::all();
        $medicinedevices = MedicineDevice::all(); 

        $transactions = transaction::with(['medicine', 'medicinedevice'])->orderBy('tanggal_transaksi', 'DESC')->get();

        return view('transactions.index', compact('transactions', 'medicines', 'medicinedevices'));
    }

    public function create()
    {
        $medicines = Medicine::all();
        $medicinedevices = MedicineDevice::all(); 
        
        return view('transactions.create', compact('medicines', 'medicinedevices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'status' => 'required|in:buy,sale',
            'medicine_id.*' => 'nullable|exists:medicines,id',
            'medicinedevice_id.*' => 'nullable|exists:medicine_devices,id',
            'jumlah.*' => 'nullable|integer|min:1',
            'jumlah_device.*' => 'nullable|integer|min:1',
        ]);
    
        foreach ($request->medicine_id as $index => $medicineId) {
            if ($medicineId) {
                $medicine = Medicine::find($medicineId);
                $transaction = Transaction::create([
                    'medicine_id' => $medicineId,
                    'status' => $request->status,
                    'jumlah' => $request->jumlah[$index],
                    'total_harga' => $medicine->harga * $request->jumlah[$index],
                    'tanggal_transaksi' => $request->tanggal_transaksi,
                ]);
    
                $this->updateStock($medicineId, null, $transaction->jumlah, $request->status === 'buy' ? 'add' : 'subtract');
            }
    
            if ($request->medicinedevice_id[$index]) {
                $device = MedicineDevice::find($request->medicinedevice_id[$index]);
                $transaction = Transaction::create([
                    'medicinedevice_id' => $request->medicinedevice_id[$index],
                    'status' => $request->status,
                    'jumlah' => $request->jumlah_device[$index],
                    'total_harga' => $device->harga * $request->jumlah_device[$index],
                    'tanggal_transaksi' => $request->tanggal_transaksi,
                ]);
    
                $this->updateStock(null, $request->medicinedevice_id[$index], $transaction->jumlah, $request->status === 'buy' ? 'add' : 'subtract');
            }
        }

        $message = $request->status == 'buy' ? 'Data Transaksi Pembelian berhasil ditambahkan' : 'Data Transaksi Penjualan berhasil ditambahkan';
    
        return redirect()->route('transactions')->with('success', $message);
    }
 
        public function show(string $id)
    {
        $transaction = Transaction::with(['medicine', 'medicinedevice'])->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }

    public function edit(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        $medicines = Medicine::all();
        $medicineDevices = MedicineDevice::all();

        return view('transactions.edit', compact('transaction', 'medicines', 'medicineDevices'));
    }

    public function update(Request $request, string $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Menyimpan data sebelum update untuk menghitung perubahan stok
        $oldMedicineId = $transaction->medicine_id;
        $oldMedicineDeviceId = $transaction->medicinedevice_id;
        $oldJumlah = $transaction->jumlah;
        $oldJumlahDevice = $transaction->jumlah_device;
        $oldStatus = $transaction->status;
        
        // Update data transaksi
        $transaction->update($request->all());
    
        // Jika ada perubahan jumlah obat
        if ($transaction->medicine_id) {
            $medicine = Medicine::find($transaction->medicine_id);
            // Menghitung perubahan stok obat
            if ($oldStatus === 'buy') {
                $this->updateStock($oldMedicineId, null, $oldJumlah, 'subtract');
            } else {
                $this->updateStock($oldMedicineId, null, $oldJumlah, 'add');
            }
            
            // Sesuaikan stok obat berdasarkan status transaksi baru
            if ($transaction->status === 'buy') {
                $this->updateStock($transaction->medicine_id, null, $transaction->jumlah, 'add');
            } else {
                $this->updateStock($transaction->medicine_id, null, $transaction->jumlah, 'subtract');
            }
    
            // Update total harga berdasarkan jumlah terbaru
            $transaction->total_harga = $medicine->harga * $transaction->jumlah;
            $transaction->save();
        }
    
        // Jika ada perubahan jumlah alat kesehatan
        if ($transaction->medicinedevice_id) {
            $device = MedicineDevice::find($transaction->medicinedevice_id);
            // Menghitung perubahan stok alat kesehatan
            if ($oldStatus === 'buy') {
                $this->updateStock(null, $oldMedicineDeviceId, $oldJumlahDevice, 'subtract');
            } else {
                $this->updateStock(null, $oldMedicineDeviceId, $oldJumlahDevice, 'add');
            }
    
            // Sesuaikan stok alat kesehatan berdasarkan status transaksi baru
            if ($transaction->status === 'buy') {
                $this->updateStock(null, $transaction->medicinedevice_id, $transaction->jumlah_device, 'add');
            } else {
                $this->updateStock(null, $transaction->medicinedevice_id, $transaction->jumlah_device, 'subtract');
            }
    
            // Update total harga berdasarkan jumlah terbaru
            $transaction->total_harga = $device->harga * $transaction->jumlah_device;
            $transaction->save();
        }

        $message = $transaction->status == 'buy' ? 'Data Transaksi Pembelian berhasil diubah' : 'Data Transaksi Penjualan berhasil diubah';
    
        return redirect()->route('transactions')->with('success', $message);
    }    

    public function destroy(string $id)
    {
        $transaction = transaction::findOrFail($id);
        
        $transaction->delete();

        $message = $transaction->status = 'buy' ? 'Data Transaksi Pembelian berhasil dihapus' : 'Data Transaksi Penjualan berhasil dihapus';

        return redirect()->route('transactions')->with('success', $message);
    }

    private function updateStock($medicineId, $medicinedeviceId, $jumlah, $operation)
    {
        if ($medicineId) {
            $medicine = Medicine::find($medicineId);
            if ($medicine) {
                // Tambah atau kurangi stok
                if ($operation === 'add') {
                    $medicine->stok += $jumlah; // Menambah stok
                } elseif ($operation === 'subtract') {
                    $medicine->stok -= $jumlah; // Mengurangi stok
                }
                $medicine->save();
            }
        }
    
        if ($medicinedeviceId) {
            $medicinedevice = MedicineDevice::find($medicinedeviceId);
            if ($medicinedevice) {
                // Tambah atau kurangi stok
                if ($operation === 'add') {
                    $medicinedevice->stok += $jumlah; // Menambah stok
                } elseif ($operation === 'subtract') {
                    $medicinedevice->stok -= $jumlah; // Mengurangi stok
                }
                $medicinedevice->save();
            }
        }
    }
    
}
