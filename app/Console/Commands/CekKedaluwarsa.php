<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BarangMasuk;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CekKedaluwarsa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cek-kedaluwarsa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menambahkan barang yang mendekati kadaluwarsa ke dalam tabel notifikasi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tanggal_sekarang = Carbon::now();
        $tanggal_h7 = Carbon::now()->addDays(7);
        $tanggal_h3 = Carbon::now()->addDays(3);

        $this->cekDanTambahkanNotifikasi($tanggal_h7, "H-7");
        $this->cekDanTambahkanNotifikasi($tanggal_h3, "H-3");

        $this->info('Pengecekan barang kedaluwarsa selesai.');
    }

    private function cekDanTambahkanNotifikasi($tanggal, $hari)
    {
        $barangKedaluwarsa = BarangMasuk::whereDate('kedaluwarsa', $tanggal)->get();

        foreach ($barangKedaluwarsa as $barang) {
            // Cek apakah notifikasi untuk H-7 atau H-3 sudah ada
            $cekNotifikasi = Notifikasi::where('barang_masuk_id', $barang->id)
                                        ->where('jenis', 'Kedaluwarsa')
                                        ->where('pesan', 'LIKE', "%$hari%") // Cek apakah notifikasi dengan H-7 atau H-3 sudah ada
                                        ->exists();

            if (!$cekNotifikasi) {
                // Tambahkan notifikasi
                Notifikasi::create([
                    'barang_masuk_id' => $barang->id,
                    'jenis' => 'Kedaluwarsa',
                    'dibaca' => false,
                    'pesan' => "Peringatan: Barang dengan ID {$barang->barang_id} akan kedaluwarsa pada {$barang->kedaluwarsa} (Pengecekan $hari).",
                ]);

                $noAdmin = "087786425111";
                #ke admin
                try {
                    $this->kirimPesan($noAdmin, "Peringatan: Barang dengan ID {$barang->barang_id} akan kedaluwarsa pada {$barang->kedaluwarsa} (Pengecekan $hari).");
                    sleep(1);
                } catch (\Exception $e) {
                    Log::error("Gagal mengirim notifikasi: " . $e->getMessage());
                }
            }
        }
    }

    private function kirimPesan($target, $message)
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
