<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicineDevice;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use Yajra\DataTables\DataTables;

class MedicineDeviceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $medicinedevices = MedicineDevice::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();
            return DataTables::of($medicinedevices)
                ->make(true);
        }
        
        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        $medicinedevices = MedicineDevice::with(['kategori', 'satuan', 'suplier'])->orderBy('created_at', 'DESC')->get();

        return view('medicinedevices.index', compact('medicinedevices', 'categories', 'satuans', 'suppliers'));
    }

    public function create()
    {
        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        return view('medicinedevices.create', compact('categories', 'satuans', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nama_alatkesehatan' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
            'satuan_id' => 'required|exists:units,id',
            'harga' => 'required|numeric|regex:/^[0-9]+$/',
            'keterangan' => 'required|string',
            'suplier_id' => 'required|exists:suppliers,id',
        ], [
            'kategori_id.required' => 'Kategori alat kesehatan harus dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'nama_alatkesehatan.required' => 'Nama alat kesehatan wajib diisi.',
            'stok.required' => 'Stok alat kesehatan wajib diisi.',
            'stok.integer' => 'Stok alat kesehatan harus berupa angka.',
            'stok.min' => 'Stok harus lebih dari 0.',
            'satuan_id.required' => 'Satuan alat kesehatan harus dipilih.',
            'satuan_id.exists' => 'Satuan yang dipilih tidak valid.',
            'harga.required' => 'Harga alat kesehatan harus diisi.',
            'harga.numeric' => 'Harga alat kesehatan harus berupa angka.',
            'harga.regex' => 'Harga alat kesehatan tidak valid.',
            'keterangan.required' => 'Keterangan alat kesehatan wajib diisi.',
            'suplier_id.required' => 'Suplier alat kesehatan harus dipilih.',
            'suplier_id.exists' => 'Suplier yang dipilih tidak valid.',
        ]);

        $medicinedevice = MedicineDevice::create($validatedData);

        $this->updateUnitCount($medicinedevice->satuan_id);

        $this->updateCategoryCount($medicinedevice->kategori_id);

        return redirect()->route('medicinedevices')->with('success', 'Data Alat Kesehatan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $medicinedevice = MedicineDevice::with(['kategori', 'satuan', 'supplier'])->findOrFail($id);

        return view('medicinedevices.show', compact('medicinedevice'));
    }

    public function edit(string $id)
    {
        $medicinedevice = MedicineDevice::with(['kategori', 'satuan', 'supplier'])->findOrFail($id);

        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); // Ambil data supplier

        return view('medicinedevices.edit', compact('medicinedevice', 'categories', 'satuans', 'suppliers'));
    }

    public function update(Request $request, string $id)
    {
        $medicinedevice = MedicineDevice::findOrFail($id);

        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nama_alatkesehatan' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
            'satuan_id' => 'required|exists:units,id',
            'harga' => 'required|numeric|regex:/^[0-9]+$/',
            'keterangan' => 'required|string',
            'suplier_id' => 'required|exists:suppliers,id',
        ], [
            'kategori_id.required' => 'Kategori alat kesehatan harus dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'nama_alatkesehatan.required' => 'Nama alat kesehatan wajib diisi.',
            'stok.required' => 'Stok alat kesehatan wajib diisi.',
            'stok.integer' => 'Stok alat kesehatan harus berupa angka.',
            'stok.min' => 'Stok harus lebih dari 0.',
            'satuan_id.required' => 'Satuan alat kesehatan harus dipilih.',
            'satuan_id.exists' => 'Satuan yang dipilih tidak valid.',
            'harga.required' => 'Harga alat kesehatan harus diisi.',
            'harga.numeric' => 'Harga alat kesehatan harus berupa angka.',
            'harga.regex' => 'Harga alat kesehatan tidak valid.',
            'keterangan.required' => 'Keterangan alat kesehatan wajib diisi.',
            'suplier_id.required' => 'Suplier alat kesehatan harus dipilih.',
            'suplier_id.exists' => 'Suplier yang dipilih tidak valid.',
        ]);

        $medicinedevice->update($validatedData);
        
        $oldSatuanId = $medicinedevice->satuan_id;
        $oldCategoryId = $medicinedevice->kategori_id; 

        if ($oldSatuanId != $medicinedevice->satuan_id) {
            $this->updateUnitCount($oldSatuanId);
            $this->updateUnitCount($medicinedevice->satuan_id);
        }
        if ($oldCategoryId != $medicinedevice->kategori_id) {
            $this->updateCategoryCount($oldCategoryId);
            $this->updateCategoryCount($medicinedevice->kategori_id);
        }

        return redirect()->route('medicinedevices')->with('success', 'Data Alat Kesehatan berhasil diubah');
    }

    public function destroy(string $id)
    {
        $medicinedevice = MedicineDevice::findOrFail($id);
        $satuanId = $medicinedevice->satuan_id;
        $categoryId = $medicinedevice->kategori_id;
        
        $medicinedevice->delete();

        $this->updateUnitCount($satuanId);

        $this->updateCategoryCount($categoryId);

        return redirect()->route('medicinedevices')->with('success', 'Data Alat Kesehatan berhasil dihapus');
    }

    private function updateUnitCount($unitId)
    {
        $unit = Unit::find($unitId);
        if ($unit) {
            $unit->jumlah = MedicineDevice::where('satuan_id', $unitId)->count();
            $unit->save();
        }
    }

    private function updateCategoryCount($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category) {
            $category->jumlah = MedicineDevice::where('kategori_id', $categoryId)->count();
            $category->save();
        }
    }
}
