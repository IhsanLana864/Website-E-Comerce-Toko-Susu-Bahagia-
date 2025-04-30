<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BarangKeluar;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangKeluar::with('barang');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }
    
        $penjualans = $query->get();

        return view('admin.laporan.index', compact('penjualans'));
    }

    public function exportPDF(Request $request)
    {
        $query = BarangKeluar::with('barang');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('updated_at', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        $penjualans = $query->get();
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('penjualans', 'tanggal_awal', 'tanggal_akhir'));

        return $pdf->download('laporan_penjualan.pdf');
    }
}
