<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();

        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
        ]);
        
        Kategori::create($request->all());

        return redirect()->route('admin.kategoris.index')->with('success', 'Kategori created successfully.');
    }

    // public function show(Room $room)
    // {
    //     return view('rooms.show', compact('room')); // Detail data
    // }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori')); // Form edit data
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'kategori' => 'required',
        ]);
        
        $kategori->kategori = $request->kategori;

        $kategori->save();

        return redirect()->route('admin.kategoris.index')->with('success', 'Kategori updated successfully.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('admin.kategoris.index')->with('success', 'Kategori deleted successfully.');
    }
}
