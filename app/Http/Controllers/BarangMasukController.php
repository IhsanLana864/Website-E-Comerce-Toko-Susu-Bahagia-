<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('barang')->get();
        return view('admin.barang_masuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('admin.barang_masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'jumlah' => 'required|integer|min:1',
            'kedaluwarsa' => 'required',
            'harga_satuan' => 'required',
            'sumber' => 'required',
            'penerima' => 'required',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $barang->stok += $request->jumlah;
        $barang->save();

        BarangMasuk::create([
            'barang_id' => $request->barang_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'jumlah' => $request->jumlah,
            'stok_sisa' => $request->jumlah,
            'kedaluwarsa' => $request->kedaluwarsa,
            'harga_satuan' => $request->harga_satuan,
            'sumber' => $request->sumber,
            'penerima' => $request->penerima,
        ]);

        return redirect()->route('admin.masuk.index')->with('success', 'Barang masuk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::find($id);
        if (!$barangMasuk) {
            return redirect()->route('admin.masuk.index')->with('error', 'Data tidak ditemukan');
        }
        
        $barangs = Barang::all();
        return view('admin.barang_masuk.edit', compact('barangMasuk', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'jumlah' => 'required|integer|min:1',
            'kedaluwarsa' => 'required',
            'harga_satuan' => 'required',
            'sumber' => 'required',
            'penerima' => 'required',
        ]);

        $barangMasuk = BarangMasuk::find($id);
        if (!$barangMasuk) {
            return redirect()->back()->with('error', 'Data barang masuk tidak ditemukan');
        }

        // Jika barang diubah, stok barang lama harus dikurangi
        if ($barangMasuk->barang_id != $request->barang_id) {
            // Kurangi stok barang lama
            $barangLama = Barang::find($barangMasuk->barang_id);
            if ($barangLama) {
                $barangLama->stok -= $barangMasuk->jumlah;
                $barangLama->save();
            }

            // Tambahkan stok ke barang baru
            $barangBaru = Barang::find($request->barang_id);
            if ($barangBaru) {
                $barangBaru->stok += $request->jumlah;
                $barangBaru->save();
            }

            // Update barang_id di barang masuk
            $barangMasuk->barang_id = $request->barang_id;
        } else {
            // Jika barang tetap sama, hanya stok yang diperbarui
            $selisih = $request->jumlah - $barangMasuk->jumlah;
            $barang = Barang::find($barangMasuk->barang_id);
            if ($barang) {
                $barang->stok += $selisih;
                $barang->save();
            }
        }

        // Perbarui data barang masuk
        $barangMasuk->tanggal = $request->tanggal;
        $barangMasuk->jam = $request->jam;
        $barangMasuk->jumlah = $request->jumlah;
        $barangMasuk->kedaluwarsa = $request->kedaluwarsa;
        $barangMasuk->harga_satuan = $request->harga_satuan;
        $barangMasuk->stok_sisa = $request->jumlah; // Pastikan stok_sisa sesuai jumlah terbaru
        $barangMasuk->sumber = $request->sumber;
        $barangMasuk->penerima = $request->penerima;
        $barangMasuk->save();

        return redirect()->route('admin.masuk.index')->with('success', 'Data barang masuk berhasil diperbarui');
    }
}