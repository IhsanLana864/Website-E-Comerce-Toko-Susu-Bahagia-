<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluars';
    protected $fillable =   ['barang_id', 'barang_masuk_id', 'tanggal', 'jam', 'jumlah', 'harga_satuan', 'keuntungan', 'penjual'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
