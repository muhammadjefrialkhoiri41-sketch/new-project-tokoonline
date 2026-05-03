<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FotoProduk extends Model
{
    use HasFactory;

    protected $table = 'foto_produk';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
// ✅ WAJIB untuk UUID
    public $incrementing = false;
    protected $keyType = 'string';

    // ✅ Auto generate UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
    }
}
