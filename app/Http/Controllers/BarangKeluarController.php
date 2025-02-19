<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Barang;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with('barang')->get();
        return view('admin.barang_keluar.index', compact('barangKeluar'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('admin.barang_keluar.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required',
            'penjual' => 'required',
        ]);

        $barang_id = $request->barang_id;
        $jumlah_dibeli = $request->jumlah;
        $harga_jual = $request->harga_satuan;
        $penjual = $request->penjual;
        $tanggal = $request->tanggal;
        $jam = $request->jam;

        // **Cek total stok yang tersedia**
        $total_stok_tersedia = BarangMasuk::where('barang_id', $barang_id)
            ->sum('stok_sisa');

        if ($jumlah_dibeli > $total_stok_tersedia) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi! Hanya tersedia ' . $total_stok_tersedia . ' unit.');
        }

        $total_harga_beli = 0;
        $sisa_dibutuhkan = $jumlah_dibeli;

        // Ambil stok berdasarkan FEFO (First Expired, First Out)
        $stok_tersedia = BarangMasuk::where('barang_id', $barang_id)
            ->where('stok_sisa', '>', 0)
            ->orderBy('kedaluwarsa', 'asc')
            ->get();

        foreach ($stok_tersedia as $stok) {
            if ($sisa_dibutuhkan == 0) break;

            if ($stok->stok_sisa >= $sisa_dibutuhkan) {
                $total_harga_beli += $stok->harga_satuan * $sisa_dibutuhkan;

                BarangKeluar::create([
                    'barang_id' => $barang_id,
                    'barang_masuk_id' => $stok->id,
                    'tanggal' => $tanggal,
                    'jam' => $jam,
                    'jumlah' => $sisa_dibutuhkan,
                    'harga_satuan' => $harga_jual,
                    'keuntungan' => ($harga_jual * $sisa_dibutuhkan) - ($stok->harga_satuan * $sisa_dibutuhkan),
                    'penjual' => $penjual,
                ]);

                $stok->stok_sisa -= $sisa_dibutuhkan;
                $stok->save();
                $sisa_dibutuhkan = 0;
            } else {
                $total_harga_beli += $stok->harga_satuan * $stok->stok_sisa;

                BarangKeluar::create([
                    'barang_id' => $barang_id,
                    'barang_masuk_id' => $stok->id,
                    'tanggal' => $tanggal,
                    'jam' => $jam,
                    'jumlah' => $stok->stok_sisa,
                    'harga_satuan' => $harga_jual,
                    'keuntungan' => ($harga_jual * $stok->stok_sisa) - ($stok->harga_satuan * $stok->stok_sisa),
                    'penjual' => $penjual,
                ]);

                $sisa_dibutuhkan -= $stok->stok_sisa;
                $stok->stok_sisa = 0;
                $stok->save();
            }
        }

        // **Kurangi stok di tabel barangs**
        $barang = Barang::find($barang_id);
        if ($barang) {
            $barang->stok -= $jumlah_dibeli;
            $barang->save();
        }

        return redirect()->route('admin.keluar.index')->with('success', 'Barang keluar berhasil ditambahkan dan stok diperbarui');
    }
}
