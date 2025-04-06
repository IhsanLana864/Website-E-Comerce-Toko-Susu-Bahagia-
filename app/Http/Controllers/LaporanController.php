<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pesanan;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Pesanan::where('status', 'Dikirim');

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
    
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }
    
        $penjualans = $query->get();
        return view('admin.laporan.index', compact('penjualans'));
    }

    public function exportPDF(Request $request)
    {
        $query = \App\Models\Pesanan::where('status', 'Dikirim');

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        $penjualans = $query->get();
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('penjualans'));

        return $pdf->download('laporan_penjualan.pdf');
    }

    // public function exportExcel()
    // {
    //     return Excel::download(new LaporanPenjualanExport, 'laporan_penjualan.xlsx');
    // }
}
