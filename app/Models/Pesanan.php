<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
    'customer_id',
    'produk_id',
    'jumlah',
    'total_harga',
    'metode_bayar',
    'status'
];

    // RELASI KE PRODUK
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}