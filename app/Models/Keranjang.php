<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $fillable = [
        'customer_id'
    ];

    public function items()
    {
        return $this->hasMany(KeranjangItem::class);
    }
}