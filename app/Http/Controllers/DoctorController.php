<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;


class DoctorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $doctors = Doctor::orderBy('created_at', 'DESC')->get();
            return DataTables::of($doctors)
                ->make(true);
        }
        $doctors = Doctor::all();


        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'nomor_hp' => 'required|string|min:7|max:15|regex:/^[0-9]+$/',
            'email' => 'required|email|unique:doctors,email|max:255',
            'alamat' => 'required|string',
        ], [
            'nama_dokter.required' => 'Nama dokter wajib diisi.',
            'spesialis.required' => 'Spesialis wajib diisi.',
            'nomor_hp.required' => 'Nomor H wajib diisi.',
            'nomor_hp.min' => 'Nomor H harus terdiri dari minimal 7 digit.',
            'nomor_hp.max' => 'Nomor H tidak boleh lebih dari 15 karakter.',
            'nomor_hp.regex' => 'Nomor Hp tidak valid',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        // Ubah format spesialis ke huruf besar
        $validatedData['spesialis'] = strtoupper($validatedData['spesialis']);

        // Simpan data ke dalam database
        Doctor::create($validatedData);

        return redirect()->route('doctors')->with('success', 'Data Dokter berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        return view('doctors.show', compact('doctor'));
    }

    public function edit(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, string $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validatedData = $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'nomor_hp' => 'required|string|min:7|max:15|regex:/^[0-9]+$/',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('doctors', 'email')->ignore($doctor->id),
            ],
            'alamat' => 'required|string',
        ], [
            'nama_dokter.required' => 'Nama dokter wajib diisi.',
            'spesialis.required' => 'Spesialis wajib diisi.',
            'nomor_hp.required' => 'Nomor H wajib diisi.',
            'nomor_hp.min' => 'Nomor H harus terdiri dari minimal 7 digit.',
            'nomor_hp.max' => 'Nomor H tidak boleh lebih dari 15 karakter.',
            'nomor_hp.regex' => 'Nomor Hp tidak valid',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        // Ubah format spesialis ke huruf besar
        $validatedData['spesialis'] = strtoupper($validatedData['spesialis']);

        $doctor->update($validatedData);

        return redirect()->route('doctors')->with('success', 'Data Pasien berhasil diubah');
    }

    public function destroy(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        $doctor->delete();

        return redirect()->route('doctors')->with('success', 'Data Dokter berhasil dihapus');
    }
}
