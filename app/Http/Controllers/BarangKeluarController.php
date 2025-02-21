<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

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

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::find($id);
        if (!$barangKeluar) {
            return redirect()->route('admin.keluar.index')->with('error', 'Data tidak ditemukan');
        }

        $barangs = Barang::all();
        return view('admin.barang_keluar.edit', compact('barangKeluar', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'barang_id' => 'required',
                'tanggal' => 'required|date',
                'jam' => 'required',
                'jumlah' => 'required|integer|min:1',
                'harga_satuan' => 'required',
                'penjual' => 'required',
            ]);

            $barangKeluar = BarangKeluar::findOrFail($id);
            $barangLama = Barang::findOrFail($barangKeluar->barang_id);
            $jumlahLama = $barangKeluar->jumlah;

            // **1. Kembalikan stok lama sebelum update**
            $barangLama->stok += $jumlahLama;
            $barangLama->save();

            // **2. Periksa total stok tersedia sebelum update**
            $total_stok_tersedia = BarangMasuk::where('barang_id', $request->barang_id)
                ->sum('stok_sisa');

            if ($request->jumlah > $total_stok_tersedia) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi! Hanya tersedia ' . $total_stok_tersedia . ' unit.');
            }

            // **3. Jangan langsung hapus barang keluar lama, cukup ubah jumlahnya jadi 0**
            BarangKeluar::where('id', $id)->update(['jumlah' => 0]);

            // **4. Kembalikan stok barang masuk yang digunakan sebelumnya**
            BarangMasuk::where('barang_id', $barangKeluar->barang_id)
                ->increment('stok_sisa', $jumlahLama);

            // **5. Gunakan FEFO (First Expired, First Out) untuk update barang masuk yang digunakan**
            $sisa_dibutuhkan = $request->jumlah;
            $stok_tersedia = BarangMasuk::where('barang_id', $request->barang_id)
                ->where('stok_sisa', '>', 0)
                ->orderBy('kedaluwarsa', 'asc')
                ->get();

            foreach ($stok_tersedia as $stok) {
                if ($sisa_dibutuhkan <= 0) break; // Jika sudah cukup, hentikan loop

                // Ambil stok yang bisa digunakan
                $stok_dipakai = min($stok->stok_sisa, $sisa_dibutuhkan);

                // Simpan data barang keluar baru sesuai stok masuk yang tersedia
                BarangKeluar::create([
                    'barang_id' => $request->barang_id,
                    'barang_masuk_id' => $stok->id,
                    'tanggal' => $request->tanggal,
                    'jam' => $request->jam,
                    'jumlah' => $stok_dipakai,
                    'harga_satuan' => $request->harga_satuan,
                    'keuntungan' => ($request->harga_satuan * $stok_dipakai) - ($stok->harga_satuan * $stok_dipakai),
                    'penjual' => $request->penjual,
                ]);

                // Kurangi stok_sisa di barang masuk
                $stok->stok_sisa -= $stok_dipakai;
                $stok->save();

                // Kurangi jumlah yang masih dibutuhkan
                $sisa_dibutuhkan -= $stok_dipakai;
            }

            // **6. Kurangi stok di tabel barangs dengan jumlah baru**
            $barangBaru = Barang::findOrFail($request->barang_id);
            $barangBaru->stok -= $request->jumlah;
            $barangBaru->save();

            DB::commit();
            return redirect()->route('admin.keluar.index')->with('success', 'Data barang keluar berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
