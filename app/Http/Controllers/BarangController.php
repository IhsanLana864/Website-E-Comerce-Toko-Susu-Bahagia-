<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Barang;
use App\Models\Kategori;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $barangs = Barang::with('kategori')->get();
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        $barangs = Barang::with('kategori')->get();
        $kategoris = Kategori::all();
        return view('admin.barang.create', compact('kategoris', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'harga' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'satuan' => 'required',
        ]);

        $fotoPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fotoPath = $file->store('uploads', 'public'); // Simpan di folder 'storage/app/public/uploads'
        }

        Barang::create([
            'nama' => $request->nama,
            'kategori_id' => $request->kategori_id,
            'harga' => $request->harga,
            'gambar' => $fotoPath, // Simpan path foto
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('admin.barangs.index')->with('success', 'Barang created successfully.');
    }

    // public function show(Room $room)
    // {
    //     return view('rooms.show', compact('room')); // Detail data
    // }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('admin.barang.edit', compact('barang', 'kategoris')); // Form edit data
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'harga' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'satuan' => 'required',
        ]);
        
        if ($request->hasFile('gambar')) {
            // Hapus foto lama jika ada
            if ($barang->gambar && \Storage::exists('public/' . $barang->gambar)) {
                \Storage::delete('public/' . $barang->gambar);
            }
    
            // Simpan foto baru
            $fotoPath = $request->file('gambar')->store('uploads', 'public');
            $barang->gambar = $fotoPath; // Perbarui path foto
        }

        $barang->nama = $request->nama;
        $barang->kategori_id = $request->kategori_id;
        $barang->harga = $request->harga;
        $barang->satuan = $request->satuan;

        $barang->save();

        return redirect()->route('admin.barangs.index')->with('success', 'Barang updated successfully.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->gambar && \Storage::exists('public/' . $barang->gambar)) {
            \Storage::delete('public/' . $barang->gambar);
        }
        
        $barang->delete();

        return redirect()->route('admin.barangs.index')->with('success', 'Barang deleted successfully.');
    }
}
