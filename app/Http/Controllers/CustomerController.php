<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;

class CustomerController extends Controller
{
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

    public function addToCart(Request $request)
    {
        $barang = Barang::find($request->barang_id);

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        if ($barang->stok <= 0) {
            return response()->json(['error' => 'Stok barang habis'], 400);
        }

        // Logika untuk menambahkan ke keranjang (bisa disesuaikan dengan model Cart)
        $cart = session()->get('cart', []);

        if (isset($cart[$barang->id])) {
            $cart[$barang->id]['quantity']++;
        } else {
            $cart[$barang->id] = [
                "name" => $barang->nama,
                "price" => $barang->harga,
                "quantity" => 1,
                "stok" => $barang->stok,
                "image" => $barang->gambar
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['success' => 'Barang berhasil ditambahkan ke keranjang']);
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        
        return view('cart', compact('cart'));
    }

    public function updateCart(Request $request)
    {
        $barang = Barang::find($request->barang_id);

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->barang_id])) {
            $maxStok = $barang->stok; // Pastikan stok terbaru dari database

            if ($request->quantity > $maxStok) {
                return response()->json(['error' => 'Stok barang sudah berubah. Silakan refresh halaman.'], 400);
            }

            $cart[$request->barang_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => 'Keranjang diperbarui',
            'total' => number_format($cart[$request->barang_id]['quantity'] * $cart[$request->barang_id]['price'], 0, ',', '.'),
            'quantity' => $cart[$request->barang_id]['quantity']
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->barang_id]);
        session()->put('cart', $cart);

        return response()->json(['success' => 'Barang dihapus dari keranjang']);
    }

    // public function checkout()
    // {
    //     $cart = session()->get('cart', []);

    //     DB::beginTransaction();
    //     try {
    //         foreach ($cart as $id => $item) {
    //             $barang = Barang::find($id);

    //             if (!$barang || $barang->stok < $item['quantity']) {
    //                 DB::rollBack();
    //                 return response()->json(['error' => 'Stok barang tidak mencukupi untuk checkout. Silakan refresh halaman.'], 400);
    //             }

    //             $barang->stok -= $item['quantity'];  // Kurangi stok di database
    //             $barang->save();
    //         }

    //         session()->forget('cart');  // Kosongkan keranjang setelah checkout
    //         DB::commit();

    //         return response()->json(['success' => 'Checkout berhasil']);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => 'Terjadi kesalahan saat checkout.'], 500);
    //     }
    // }
}
