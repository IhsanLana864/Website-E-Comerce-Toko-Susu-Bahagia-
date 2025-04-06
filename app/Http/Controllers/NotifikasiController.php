<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::latest()->get();
        return view('admin.layouts.main', compact('notifikasis'));
    }

    public function markAsRead($id)
    {
        $notif = Notifikasi::find($id);
        if (!$notif) {
            return response()->json(['success' => false, 'message' => 'Notifikasi tidak ditemukan'], 404);
        }

        $notif->update(['dibaca' => true]); 

        return response()->json(['success' => true]);
    }
}
