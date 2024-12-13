<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employees = Employee::orderBy('created_at', 'DESC')->get();
            return DataTables::of($employees)
                ->make(true);
        }
        $employees = Employee::all();


        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'nomor_hp' => 'required|string|min:7|max:15|regex:/^[0-9]+$/',
            'email' => 'required|email|unique:employees,email|max:255',
            'alamat' => 'required|string|max:255',
        ], [
            'nama_karyawan.required' => 'Nama karyawan wajib diisi.',
            'posisi.required' => 'Posisi wajib diisi.',
            'umur.required' => 'Usia wajib diisi.',
            'umur.integer' => 'Usia harus berupa angka.',
            'umur.min' => 'Usia harus lebih dari 0.',
            'nomor_hp.required' => 'Nomor Hp wajib diisi.',
            'nomor_hp.min' => 'Nomor Hp harus terdiri dari minimal 7 digit.',
            'nomor_hp.max' => 'Nomor Hp tidak boleh lebih dari 15 karakter.',
            'nomor_hp.regex' => 'Nomor Hp tidak valid',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        $validatedData['posisi'] = strtoupper($validatedData['posisi']);

        // Simpan data ke dalam database
        Employee::create($validatedData);

        return redirect()->route('employees')->with('success', 'Data Karyawan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);

        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validatedData = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'nomor_hp' => 'required|string|min:7|max:15|regex:/^[0-9]+$/',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('employees', 'email')->ignore($employee->id),
            ],
            'alamat' => 'required|string|max:255',
        ], [
            'nama_karyawan.required' => 'Nama karyawan wajib diisi.',
            'posisi.required' => 'Posisi wajib diisi.',
            'umur.required' => 'Usia wajib diisi.',
            'umur.integer' => 'Usia harus berupa angka.',
            'umur.min' => 'Usia harus lebih dari 0.',
            'nomor_hp.required' => 'Nomor Hp wajib diisi.',
            'nomor_hp.min' => 'Nomor Hp harus terdiri dari minimal 7 digit.',
            'nomor_hp.max' => 'Nomor Hp tidak boleh lebih dari 15 karakter.',
            'nomor_hp.regex' => 'Nomor Hp tidak valid',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        $validatedData['posisi'] = strtoupper($validatedData['posisi']);
    
        // Update data employee
        $employee->update($validatedData);

        return redirect()->route('employees')->with('success', 'Data Pasien berhasil diubah');
    }

    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->delete();

        return redirect()->route('employees')->with('success', 'Data Karyawan berhasil dihapus');
    }
}
