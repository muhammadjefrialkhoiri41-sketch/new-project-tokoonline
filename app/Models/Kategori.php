<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'foto',
        'status'
    ];

    /**
     * Relasi kategori ke produk
     */
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }

    /**
     * UUID settings
     */
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Boot model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            // Generate UUID jika id kosong
            if (!$model->id) {
                $model->id = Str::uuid();
            }

            // Generate slug otomatis
            if (!$model->slug) {
                $model->slug = Str::slug($model->nama_kategori);
            }

            // Status default aktif
            if ($model->status === null) {
                $model->status = 1;
            }
        });

        static::updating(function ($model) {

            // Update slug otomatis saat nama kategori berubah
            $model->slug = Str::slug($model->nama_kategori);
        });
    }
}