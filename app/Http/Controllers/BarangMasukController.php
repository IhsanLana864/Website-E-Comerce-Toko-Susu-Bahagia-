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
}
