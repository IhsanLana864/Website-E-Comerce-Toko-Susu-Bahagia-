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

        try {
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
    
            notify()->success('Barang berhasil ditambahkan!');
            return redirect()->route('admin.barangs.index');
        } catch (\Exception $e) {
            notify()->error('Barang gagal ditambahkan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required',
            'kategori_id' => 'required',
            'harga' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'satuan' => 'required',
        ]);
        
        try { // Tambahkan blok try-catch
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
    
            notify()->success('Barang berhasil diupdate!'); // Notifikasi sukses
            return redirect()->route('admin.barangs.index');
        } catch (\Exception $e) { // Tangkap exception
            notify()->error('Barang gagal diupdate: ' . $e->getMessage()); // Notifikasi error
            return back()->withInput(); // Redirect kembali dengan input lama
        }
    }

    public function destroy(Barang $barang)
    {
        try {
            if ($barang->gambar && \Storage::exists('public/' . $barang->gambar)) {
                \Storage::delete('public/' . $barang->gambar);
            }
            
            $barang->delete();
    
            notify()->success('Barang berhasil dihapus!');
            return redirect()->route('admin.barangs.index');
        } catch (\Exception $e) {
            notify()->error('Barang gagal dihapus: ' . $e->getMessage());
            return redirect()->route('admin.barangs.index');
        }
    }
}
