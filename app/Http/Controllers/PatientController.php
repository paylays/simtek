<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Yajra\DataTables\DataTables;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $patients = Patient::orderBy('created_at', 'DESC')->get();
            return DataTables::of($patients)
                ->make(true);
        }

        $patients = Patient::all();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'nomor_hp' => 'required|string|min:7|max:15|regex:/^[0-9]+$/',
            'alamat' => 'required|string',
        ], [
            'nama_pasien.required' => 'Nama pasien wajib diisi.',
            'umur.required' => 'Usia wajib diisi.',
            'umur.integer' => 'Usia harus berupa angka.',
            'umur.min' => 'Usia harus lebih dari 0.',
            'nomor_hp.required' => 'Nomor Hp wajib diisi.',
            'nomor_hp.min' => 'Nomor Hp harus terdiri dari minimal 7 digit.',
            'nomor_hp.max' => 'Nomor Hp tidak boleh lebih dari 15 karakter.',
            'nomor_hp.regex' => 'Nomor Hp tidak valid',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);
    
        Patient::create($validatedData);
        
        return redirect()->route('patients')->with('success', 'Data Pasien berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);

        return view('patients.show', compact('patient'));
    }

    public function edit(string $id)
    {
        $patient = Patient::findOrFail($id);

        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, string $id)
    {
        $patient = Patient::findOrFail($id);
        
        $validatedData = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'nomor_hp' => 'required|string|min:7|max:15',
            'alamat' => 'required|string',
        ], [
            'nama_pasien.required' => 'Nama pasien wajib diisi.',
            'umur.required' => 'Usia wajib diisi.',
            'umur.integer' => 'Usia harus berupa angka.',
            'umur.min' => 'Usia harus lebih dari 0.',
            'nomor_hp.required' => 'Nomor handphone wajib diisi.',
            'nomor_hp.min' => 'Nomor handphone harus terdiri dari minimal 7 digit.',
            'nomor_hp.max' => 'Nomor handphone tidak boleh lebih dari 15 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);
    
        $patient->update($validatedData);
    

        return redirect()->route('patients')->with('success', 'Data Pasien berhasil diubah');
    }

    public function destroy(string $id)
    {
        $patient = Patient::findOrFail($id);

        $patient->delete();
        
        return redirect()->route('patients')->with('success', 'Data Pasien berhasil dihapus');
    }
}
