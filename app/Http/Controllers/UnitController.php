<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = Unit::orderBy('created_at', 'DESC')->get();
            return DataTables::of($units)
                ->make(true);
        }

        $units = Unit::all();

        return view('units.index', compact('units'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama_satuan' => 'required|string|max:255',
        ], [
            'nama_satuan.required' => 'Nama satuan wajib diisi.'
        ]);

    
        Unit::create([
            'nama_satuan' => $validatedData['nama_satuan'],
            'jumlah' => 0,
        ]);

        return redirect()->route('units')->with('success', 'Data Satuan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $unit = Unit::findOrFail($id);

        return view('units.show', compact('unit'));
    }

    public function edit(string $id)
    {
        $unit = Unit::findOrFail($id);

        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, string $id)
    {
        $unit = Unit::findOrFail($id);

        $validatedData = $request->validate([
            'nama_satuan' => 'required|string|max:255',
        ], [
            'nama_satuan.required' => 'Nama satuan wajib diisi.'
        ]);

        $unit->update($validatedData);

        return redirect()->route('units')->with('success', 'Data Satuan berhasil diubah');
    }

    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);

        $unit->delete();

        return redirect()->route('units')->with('success', 'Data Satuan berhasil dihapus');
    }
}
