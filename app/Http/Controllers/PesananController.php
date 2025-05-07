<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $pesanans = Pesanan::get();

        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function edit(Pesanan $pesanan)
    {
        return view('admin.pesanan.edit', compact('pesanan')); // Form edit data
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            // Jika status pesanan ditolak, kembalikan stok
            if ($request->status == 'Ditolak' && $pesanan->status != 'Ditolak') {
                $details = DetailPesanan::where('pesanan_id', $pesanan->id)->get();
                
                foreach ($details as $detail) {
                    // Kembalikan stok ke barang_masuk
                    $barangMasuk = BarangMasuk::find($detail->barang_masuk_id);
                    $barangMasuk->increment('stok_sisa', $detail->jumlah);

                    // Kembalikan stok ke barang utama
                    $barang = Barang::find($detail->barang_id);
                    $barang->increment('stok', $detail->jumlah);
                }
            }

            // Jika status pesanan diterima, buat barang_keluar
            if ($request->status == 'Diterima' && $pesanan->status != 'Diterima') {
                $details = DetailPesanan::where('pesanan_id', $pesanan->id)->get();
                
                foreach ($details as $detail) {
                    $barangMasuk = BarangMasuk::find($detail->barang_masuk_id);

                    BarangKeluar::create([
                        'barang_id' => $detail->barang_id,
                        'barang_masuk_id' => $detail->barang_masuk_id,
                        'tanggal' => now(),
                        'jam' => now()->format('H:i:s'),
                        'jumlah' => $detail->jumlah,
                        'harga_satuan' => $detail->harga,
                        'keuntungan' => max(0, ($detail->harga - $barangMasuk->harga_satuan) * $detail->jumlah),
                        'penjual' => $pesanan->nama,
                    ]);
                }
            }

            // Update status pesanan
            $pesanan->status = $request->status;
            $pesanan->save();

            DB::commit();

            // Notifikasi ke WA pelanggan
            try {
                $this->kirimPesan($pesanan->no_telepon, "Pesanan anda " . $request->status);
            } catch (\Exception $e) {
                Log::error("Gagal mengirim notifikasi: " . $e->getMessage());
            }
            
            if (!$pesanan) {
                throw new \Exception("Pesanan gagal disimpan.");
            }

            notify()->success('Status pesanan berhasil diperbarui!');
            return redirect()->route('admin.pesanan.index');
        } catch (\Exception $e) {
            DB::rollBack();
            notify()->error('Status pesanan gagal diperbarui: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function kirimPesan($target, $message)
    {
        $token = env('FONTEE_API_KEY');

        try {
            // Pastikan token ada
            if (!$token) {
                Log::error("Token API Fonnte tidak ditemukan di .env.");
                return false;
            }
    
            // Kirim request ke API
            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message
            ]);
    
            // Ambil status dan respons API
            $statusCode = $response->status();
            $body = $response->json();
    
            // Logging response dari API
            Log::info("Respon dari Fonnte API", [
                'status' => $statusCode,
                'body' => $body
            ]);
    
            // Jika respons bukan 200, catat error
            if ($statusCode !== 200) {
                Log::error("Gagal mengirim pesan ke Fonnte.", [
                    'status' => $statusCode,
                    'response' => $body
                ]);
            }
    
            return $body;
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan dalam kirimPesan()", [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return false;
        }
    }
}