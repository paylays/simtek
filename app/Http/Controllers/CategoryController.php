<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::orderBy('created_at', 'DESC')->get();
            return DataTables::of($categories)
                ->make(true);
        }
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.'
        ]);

    
        Category::create([
            'nama_kategori' => $validatedData['nama_kategori'],
            'jumlah' => 0,
        ]);


        return redirect()->route('categories')->with('success', 'Data Kategori berhasil ditambahkan');
    }


    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return view('categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.'
        ]);

        $category->update($validatedData);

        return redirect()->route('categories')->with('success', 'Data Kategori berhasil diubah');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('categories')->with('success', 'Data Kategori berhasil dihapus');
    }
}
