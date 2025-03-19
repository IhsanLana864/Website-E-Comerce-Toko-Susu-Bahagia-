<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable =   [
                                'nama', 'alamat', 'no_telepon',
                                'total_harga',
                                'ekspedisi', 'status', 'bukti',
                                'order_id'
                            ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }     
    
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
}
