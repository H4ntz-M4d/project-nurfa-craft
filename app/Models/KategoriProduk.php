<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = "kategori_produk";
    protected $primaryKey = "id_ktg_produk";
    public $timestamps = true;
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'deskripsi',
        'status',
        'meta_keywords',
        'meta_desc',
        'gambar',
        'slug'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategoriProduk) {
            $kategoriProduk->slug = md5(now()->timestamp);
        });
    }
}
