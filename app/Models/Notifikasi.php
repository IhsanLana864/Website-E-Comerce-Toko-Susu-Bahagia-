<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable =   ['pesanan_id', 'barang_masuk_id', 'jenis', 'tanggal_dibaca', 'dibaca', 'pesan'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function barangMasuk()
    {
        return $this->belongsTo(barangMasuk::class, 'barang_masuk_id');
    }
}
