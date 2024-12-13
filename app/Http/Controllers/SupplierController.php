<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $suppliers = Supplier::orderBy('created_at', 'DESC')->get();
            return DataTables::of($suppliers)
                ->make(true);
        }
        
        $suppliers = Supplier::all();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama_suplier' => 'required|string|max:255',
            'nomor_hp' => 'required|string|min:7|max:15|regex:/^[0-9]+$/',
            'email' => 'required|email|unique:suppliers,email|max:255',
            'alamat' => 'required|string|max:255',
        ], [
            'nama_suplier.required' => 'Nama suplier wajib diisi.',
            'nomor_hp.required' => 'Nomor hp wajib diisi.',
            'nomor_hp.min' => 'Nomor hp harus terdiri dari minimal 7 digit.',
            'nomor_hp.max' => 'Nomor hp tidak boleh lebih dari 15 karakter.',
            'nomor_hp.regex' => 'Nomor hp tidak valid',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        Supplier::create($validatedData);

        return redirect()->route('suppliers')->with('success', 'Data Supplier berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('suppliers.show', compact('supplier'));
    }

    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validatedData = $request->validate([
            'nama_suplier' => 'required|string|max:255',
            'nomor_hp' => 'required|string|min:7|max:15|regex:/^[0-9]+$/',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('suppliers', 'email')->ignore($supplier->id),
            ],
            'alamat' => 'required|string|max:255',
        ], [
            'nama_suplier.required' => 'Nama suplier wajib diisi.',
            'nomor_hp.required' => 'Nomor hp wajib diisi.',
            'nomor_hp.min' => 'Nomor hp harus terdiri dari minimal 7 digit.',
            'nomor_hp.max' => 'Nomor hp tidak boleh lebih dari 15 karakter.',
            'nomor_hp.regex' => 'Nomor hp tidak valid',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        $supplier->update($validatedData);

        return redirect()->route('suppliers')->with('success', 'Data Pasien berhasil diubah');
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        return redirect()->route('suppliers')->with('success', 'Data Supplier berhasil dihapus');
    }
}
