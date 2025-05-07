<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::get();

        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
        ]);

        try {
            Kategori::create($request->all());
    
            notify()->success('Kategori berhasil ditambahkan!');
            return redirect()->route('admin.kategoris.index');
        } catch (\Exception $e) {
            notify()->error('Kategori gagal ditambahkan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'kategori' => 'required',
        ]);

        try {
            $kategori->kategori = $request->kategori;

            $kategori->save();
    
            notify()->success('Kategori berhasil diperbarui!');
            return redirect()->route('admin.kategoris.index');
        } catch (\Exception $e) {
            notify()->error('Kategori gagal diperbarui: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy(Kategori $kategori)
    {
        try {
            $kategori->delete();
    
            notify()->success('Kategori berhasil dihapus!');
            return redirect()->route('admin.kategoris.index');
        } catch (\Exception $e) {
            notify()->error('Kategori gagal dihapus: ' . $e->getMessage());
            return redirect()->route('admin.kategoris.index');
        }
    }
}
