<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        #Fix Time
        #top 3 barang laku
        $topBarangKeluar = BarangKeluar::select('barang_id', DB::raw('SUM(jumlah) as total_keluar'))
            ->groupBy('barang_id')
            ->orderByDesc('total_keluar')
            ->take(3)
            ->with('barang') // relasi ke tabel barang
            ->get();

        #barang mau abis
        $stokHampirHabis = Barang::where('stok', '<', 4)->get();

        #barang mau basi
        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();
        $barangKadaluarsa = DB::table('barang_masuks')
            ->join('barangs', 'barang_masuks.barang_id', '=', 'barangs.id')
            ->whereBetween('kedaluwarsa', [$awalBulan, $akhirBulan])
            ->select('barang_masuks.*', 'barangs.nama as nama_barang')
            ->get();

        #Custom Waktu
        // FILTER: today, month, all, custom
        $filter = $request->input('filter', 'today');
        $waktuInput = $request->input('waktu', Carbon::now()->format('Y-m'));

        // Default
        $startDate = Carbon::today();
        $endDate = Carbon::today();
        
        if ($filter === 'month') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } elseif ($filter === 'all') {
            $startDate = Carbon::create(2000, 1, 1); // asumsi awal data
            $endDate = Carbon::now();
        } elseif ($filter === 'custom') {
            $customDate = Carbon::createFromFormat('Y-m', $waktuInput);
            $startDate = $customDate->copy()->startOfMonth();
            $endDate = $customDate->copy()->endOfMonth();
        }

        $labelWaktu = 'Hari Ini';
        if ($filter === 'month') {
            $labelWaktu = 'Bulan Ini';
        } elseif ($filter === 'custom') {
            $labelWaktu = 'Bulan ' . Carbon::createFromFormat('Y-m', $waktuInput)->translatedFormat('F');
        } elseif ($filter === 'all') {
            $labelWaktu = 'Semua Waktu';
        }

        $jumlahPesanan = Pesanan::whereBetween('created_at', [$startDate, $endDate])->count();
        $jumlahBarangMasuk = BarangMasuk::whereBetween('tanggal', [$startDate, $endDate])->count();
        $jumlahBarangKeluar = BarangKeluar::whereBetween('tanggal', [$startDate, $endDate])->count();
        $jumlahKeuntungan = BarangKeluar::whereBetween('tanggal', [$startDate, $endDate])->sum('keuntungan');

        if ($filter === 'all') {
            // Data pesanan per bulan
            $pesananChart = Pesanan::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as label"),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy('label')
            ->orderBy('label')
            ->get();
        
            // Keuntungan per bulan (sudah ada)
            $keuntunganChart = BarangKeluar::select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as label"),
                DB::raw("SUM(keuntungan) as total")
            )
            ->groupBy('label')
            ->orderBy('label')
            ->get();
        } else {
            // Data pesanan per hari
            $pesananChart = Pesanan::select(
                DB::raw("DATE(created_at) as label"),
                DB::raw("COUNT(*) as total")
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('label')
            ->orderBy('label')
            ->get();
        
            // Data keuntungan per hari
            $keuntunganChart = BarangKeluar::select(
                DB::raw("DATE(tanggal) as label"),
                DB::raw("SUM(keuntungan) as total")
            )
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('label')
            ->orderBy('label')
            ->get();
        }        

        return view('admin.dashboard', compact(
            'topBarangKeluar', 'stokHampirHabis',
            'barangKadaluarsa', 'jumlahPesanan',
            'jumlahBarangMasuk', 'jumlahBarangKeluar',
            'jumlahKeuntungan', 'pesananChart', 
            'keuntunganChart', 'filter', 
            'waktuInput', 'labelWaktu'
        ));
    }
}
