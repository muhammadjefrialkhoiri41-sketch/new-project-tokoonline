<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangItem extends Model
{
    protected $table = 'keranjang_item';

    protected $fillable = [
        'keranjang_id',
        'produk_id',
        'qty'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
