<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $barangMasuk = BarangMasuk::with('barang')->get();

        return view('admin.barang_masuk.index', compact('barangMasuk'));
    }

    public function show($id)
    {
        $barangMasuk = BarangMasuk::find($id);
        if (!$barangMasuk) {
            return redirect()->route('admin.masuk.index')->with('error', 'Data tidak ditemukan');
        }
        
        $barang = Barang::find($barangMasuk->barang_id);
        return view('admin.barang_masuk.show', compact('barangMasuk', 'barang'));
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

        try {
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

            notify()->success('Barang Masuk berhasil ditambahkan!');
            return redirect()->route('admin.masuk.index');
        } catch (\Exception $e) {
            notify()->error('Barang Masuk gagal ditambahkan: ' . $e->getMessage());
            return back()->withInput();
        }
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

        try {
            $barangMasuk = BarangMasuk::find($id);
            if (!$barangMasuk) {
                return redirect()->back()->with('error', 'Data barang masuk tidak ditemukan');
            }

            $barangLama = Barang::find($barangMasuk->barang_id);
            if (!$barangLama) {
                return redirect()->back()->with('error', 'Barang lama tidak ditemukan');
            }

            $barangBaru = Barang::find($request->barang_id);
            if (!$barangBaru) {
                return redirect()->back()->with('error', 'Barang baru tidak ditemukan');
            }

            // Hitung selisih perubahan jumlah
            $selisih = $request->jumlah - $barangMasuk->jumlah;

            // Update stok barang
            if ($barangLama->id == $barangBaru->id) {
                // Jika barang yang diubah adalah barang yang sama
                $barangLama->stok += $selisih;
                $barangLama->save();
            } else {
                // Jika barang yang diubah berbeda
                $barangLama->stok -= $barangMasuk->jumlah; // Kurangi stok barang lama
                $barangLama->save();

                $barangBaru->stok += $request->jumlah; // Tambah stok barang baru
                $barangBaru->save();
            }

            // Update stok_sisa berdasarkan perubahan jumlah
            $barangMasuk->stok_sisa += $selisih;

            // Pastikan stok_sisa tidak lebih dari jumlah barang masuk
            if ($barangMasuk->stok_sisa > $request->jumlah) {
                $barangMasuk->stok_sisa = $request->jumlah;
            }

            // Update data barang masuk
            $barangMasuk->barang_id = $request->barang_id;
            $barangMasuk->tanggal = $request->tanggal;
            $barangMasuk->jam = $request->jam;
            $barangMasuk->jumlah = $request->jumlah;
            $barangMasuk->kedaluwarsa = $request->kedaluwarsa;
            $barangMasuk->harga_satuan = $request->harga_satuan;
            $barangMasuk->sumber = $request->sumber;
            $barangMasuk->penerima = $request->penerima;
            $barangMasuk->save();

            notify()->success('Barang Masuk berhasil diperbarui!');
            return redirect()->route('admin.masuk.index');
        } catch (\Exception $e) {
            notify()->error('Barang Masuk gagal diperbarui: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    //SEARCH
    public function searchBarangAjax(Request $request)
    {
        $search = $request->q;

        $barangs = Barang::where('nama', 'LIKE', "%$search%")
            ->select('id', 'nama')
            ->limit(5)
            ->get();

        return response()->json($barangs);
    }
}