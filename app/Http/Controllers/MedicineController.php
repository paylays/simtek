<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use Yajra\DataTables\DataTables;

class MedicineController extends Controller
{
    public function index(Request $request)
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

        return view('medicines.index', compact('medicines', 'categories', 'satuans', 'suppliers'));
    }

    public function create()
    {
        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        return view('medicines.create', compact('categories', 'satuans', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nama_obat' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
            'satuan_id' => 'required|exists:units,id',
            'harga' => 'required|numeric|regex:/^[0-9]+$/',
            'keterangan' => 'required|string',
            'suplier_id' => 'required|exists:suppliers,id',
        ], [
            'kategori_id.required' => 'Kategori obat harus dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'stok.required' => 'Stok obat wajib diisi.',
            'stok.integer' => 'Stok obat harus berupa angka.',
            'stok.min' => 'Stok harus lebih dari 0.',
            'satuan_id.required' => 'Satuan obat harus dipilih.',
            'satuan_id.exists' => 'Satuan yang dipilih tidak valid.',
            'harga.required' => 'Harga obat harus diisi.',
            'harga.numeric' => 'Harga obat harus berupa angka.',
            'harga.regex' => 'Harga obat tidak valid.',
            'keterangan.required' => 'Keterangan obat wajib diisi.',
            'suplier_id.required' => 'Suplier obat harus dipilih.',
            'suplier_id.exists' => 'Suplier yang dipilih tidak valid.',
        ]);

        $medicine = Medicine::create($validatedData);

        $this->updateUnitCount($medicine->satuan_id);

        $this->updateCategoryCount($medicine->kategori_id);

        return redirect()->route('medicines')->with('success', 'Data Obat berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $medicine = Medicine::with(['kategori', 'satuan', 'supplier'])->findOrFail($id);

        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); 

        return view('medicines.show', compact('medicine', 'categories', 'satuans', 'suppliers'));
    }

    public function edit(string $id)
    {
        $medicine = Medicine::with(['kategori', 'satuan', 'supplier'])->findOrFail($id);

        $categories = Category::all();
        $satuans = Unit::all();
        $suppliers = Supplier::all(); // Ambil data supplier

        return view('medicines.edit', compact('medicine', 'categories', 'satuans', 'suppliers'));
    }

    public function update(Request $request, string $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nama_obat' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
            'satuan_id' => 'required|exists:units,id',
            'harga' => 'required|numeric',
            'keterangan' => 'required|string',
            'suplier_id' => 'required|exists:suppliers,id',
        ], [
            'kategori_id.required' => 'Kategori obat harus dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'nama_obat.required' => 'Nama obat wajib diisi.',
            'stok.required' => 'Stok obat wajib diisi.',
            'stok.integer' => 'Stok obat harus berupa angka.',
            'stok.min' => 'Stok harus lebih dari 0.',
            'satuan_id.required' => 'Satuan obat harus dipilih.',
            'satuan_id.exists' => 'Satuan yang dipilih tidak valid.',
            'harga.required' => 'Harga obat harus diisi.',
            'harga.numeric' => 'Harga obat harus berupa angka.',
            'keterangan.required' => 'Keterangan obat wajib diisi.',
            'suplier_id.required' => 'Suplier obat harus dipilih.',
            'suplier_id.exists' => 'Suplier yang dipilih tidak valid.',
        ]); 

        $medicine->update($validatedData);

        $oldSatuanId = $medicine->satuan_id; 
        $oldCategoryId = $medicine->kategori_id;

        if ($oldSatuanId != $medicine->satuan_id) {
            $this->updateUnitCount($oldSatuanId);
            $this->updateUnitCount($medicine->satuan_id);
        }

        if ($oldCategoryId != $medicine->kategori_id) {
            $this->updateCategoryCount($oldCategoryId);
            $this->updateCategoryCount($medicine->kategori_id);
        }

        return redirect()->route('medicines')->with('success', 'Data Obat berhasil diubah');
    }

    public function destroy(string $id)
    {
        $medicine = Medicine::findOrFail($id);
        $satuanId = $medicine->satuan_id;
        $categoryId = $medicine->kategori_id;
        
        $medicine->delete();

        $this->updateUnitCount($satuanId);

        $this->updateCategoryCount($categoryId);

        return redirect()->route('medicines')->with('success', 'Data Obat berhasil dihapus');
    }

    private function updateUnitCount($unitId)
    {
        $unit = Unit::find($unitId);
        if ($unit) {
            $unit->jumlah = Medicine::where('satuan_id', $unitId)->count();
            $unit->save();
        }
    }

    private function updateCategoryCount($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category) {
            $category->jumlah = Medicine::where('kategori_id', $categoryId)->count();
            $category->save();
        }
    }

}
