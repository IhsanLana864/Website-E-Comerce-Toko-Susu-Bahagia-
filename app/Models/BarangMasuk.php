<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuks';
    protected $fillable =   ['barang_id', 'tanggal', 'jam', 'jumlah', 'kedaluwarsa', 'harga_satuan', 'stok_sisa', 'sumber', 'penerima'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
}
