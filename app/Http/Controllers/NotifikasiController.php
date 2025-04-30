<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $notifikasis = Notifikasi::latest()->paginate(10);

        if ($request->ajax()) {
            return view('partials.admin.notifikasi-list', compact('notifikasis'))->render();
        }

        return view('admin.notifikasi', compact('notifikasis'));
    }

    public function markAsRead($id)
    {
        $notif = Notifikasi::find($id);
        if ($notif) {
            $notif->dibaca = true;
            $notif->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
