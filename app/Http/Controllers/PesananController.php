<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::all();
        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function edit(Pesanan $pesanan)
    {
        return view('admin.pesanan.edit', compact('pesanan')); // Form edit data
    }
}
