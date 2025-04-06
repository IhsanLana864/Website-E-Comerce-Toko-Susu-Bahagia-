<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
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

    public function index(Request $request)
    {
        $kategori = $request->kategori ?? 'all'; // Pastikan kategori memiliki nilai default

        if ($request->ajax()) {
            $barangs = ($kategori === "all") 
                ? Barang::all() 
                : Barang::whereHas('kategori', function ($query) use ($kategori) {
                    $query->where('kategori', $kategori);
                })->get();

            return response()->json($barangs);
        }

        $barangs = Barang::all();
        return view('index', compact('barangs'));
    }

    public function tracking()
    {
        return view('tracking');
    }

    public function addToCart(Request $request)
    {
        $barang = Barang::find($request->barang_id);

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        if ($barang->stok <= 0) {
            return response()->json(['error' => 'Stok barang habis'], 400);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$barang->id])) {
            $cart[$barang->id]['quantity'] += 1;
        } else {
            $cart[$barang->id] = [
                "id" => $barang->id,
                "name" => $barang->nama,
                "price" => $barang->harga,
                "quantity" => 1,
                "stok" => $barang->stok,
                "image" => $barang->gambar
            ];
        }

        session()->put('cart', $cart);
        
        $totalHarga = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return response()->json([
            'success' => 'Barang berhasil ditambahkan ke keranjang',
            'totalHarga' => number_format($totalHarga, 0, ',', '.')
        ]);
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        
        return view('cart', compact('cart'));
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$request->barang_id])) {
            return response()->json(['error' => 'Barang tidak ditemukan di keranjang'], 404);
        }

        $cart[$request->barang_id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        // Hitung total harga seluruh keranjang
        $totalHarga = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return response()->json([
            'quantity' => $cart[$request->barang_id]['quantity'],
            'total' => number_format($cart[$request->barang_id]['price'] * $cart[$request->barang_id]['quantity'], 0, ',', '.'),
            'totalHarga' => number_format($totalHarga, 0, ',', '.') // Kirim total harga ke frontend
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->barang_id]);
        session()->put('cart', $cart);

        return response()->json(['success' => 'Barang dihapus dari keranjang']);
    }
    
    public function cartDetail()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong, silakan pesan barang.');
        }
        
        return view('cart-detail', compact('cart'));
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja kosong.');
        }
        
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|regex:/^08[0-9]{8,11}$/',
            'ekspedisi' => 'nullable|string',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Hitung total harga berdasarkan data dari cart
        $totalHarga = collect($cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        DB::beginTransaction();
        try {
            // Simpan gambar bukti transfer ke storage
            $buktiPath = $request->file('bukti')->store('bukti_transfer', 'public');

            $ekspedisiValue = $request->pengiriman == 'internal' ? 'Internal' : $request->ekspedisi;

            $order_id = Str::uuid();

            // Simpan pesanan dengan total harga yang dihitung
            $pesanan = Pesanan::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'total_harga' => $totalHarga,
                'ekspedisi' => $ekspedisiValue,
                'bukti' => $buktiPath,
                'status' => 'Pending',
                'order_id' => $order_id,
            ]);

            Notifikasi::create([
                'pesanan_id' => $pesanan->id,
                'jenis' => 'Pesanan',
                'dibaca' => false,
                'pesan' => "Pesanan baru dari {$request->nama} telah dibuat dengan total harga Rp{$totalHarga}.",
            ]);

            // Kirim notifikasi ke admin lewat Fontee
            $noAdmin = "087786425111";
            #ke admin
            try {
                $this->kirimPesan($noAdmin, "Pesanan Baru dari: #" . $request->nama);
            } catch (\Exception $e) {
                Log::error("Gagal mengirim notifikasi: " . $e->getMessage());
            }
            
            if (!$pesanan) {
                throw new \Exception("Pesanan gagal disimpan.");
            }

            // #ke customer
            // try {
            //     $this->kirimPesan($request->no_telepon, "Pesanan Anda sudah dicatat dan sedang diproses: #Order_id " . $order_id);
            // } catch (\Exception $e) {
            //     Log::error("Gagal mengirim notifikasi: " . $e->getMessage());
            // }
            
            // if (!$pesanan) {
            //     throw new \Exception("Pesanan gagal disimpan.");
            // }
            
            // Proses setiap item di cart dengan logika FEFO
            foreach ($cart as $item) {
                $barang = Barang::findOrFail($item['id']);
                $jumlahDibutuhkan = $item['quantity'];
                
                // Ambil batch stok (barang_masuk) berdasarkan FEFO (tanggal kedaluwarsa terdekat)
                $stokTersedia = \App\Models\BarangMasuk::where('barang_id', $item['id'])
                                    ->where('stok_sisa', '>', 0)
                                    ->orderBy('kedaluwarsa', 'asc')
                                    ->get();
                
                foreach ($stokTersedia as $stok) {
                    if ($jumlahDibutuhkan <= 0) break;
                    
                    // Alokasikan jumlah dari batch ini
                    $alokasi = min($stok->stok_sisa, $jumlahDibutuhkan);
                    
                    // Simpan detail pesanan untuk batch ini, termasuk barang_masuk_id
                    DetailPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'barang_id' => $item['id'],
                        'barang_masuk_id' => $stok->id,
                        'jumlah' => $alokasi,
                        'harga' => $item['price'],
                    ]);
                    
                    // Kurangi stok_sisa pada batch dan stok global barang
                    $stok->decrement('stok_sisa', $alokasi);
                    $barang->decrement('stok', $alokasi);
                    
                    $jumlahDibutuhkan -= $alokasi;
                }
                
                if ($jumlahDibutuhkan > 0) {
                    throw new \Exception("Stok tidak mencukupi untuk barang: " . $barang->nama);
                }
            }
            
            // Kosongkan keranjang belanja
            session()->forget('cart');

            DB::commit();

            // Redirect ke halaman informasi pesanan (pastikan rute dan view pesanan.show sudah dibuat)
            return redirect()->route('index', ['id' => $pesanan->id])
                            ->with('success', 'Checkout berhasil. Silakan cek informasi pesanan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart')->withInput()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    public function showPesanan(Request $request)
    {
        $order_id = $request->order_id;
        
        $pesanan = Pesanan::where('order_id', $order_id)
            ->with('detailPesanan.barang')
            ->first();
        
        if (!$pesanan) {
            return redirect()->route('tracking')->with('error', 'Order ID tidak ditemukan. Silakan periksa kembali input Anda.');
        }
        
        return view('pesanan-detail', compact('pesanan'));
    }
}
