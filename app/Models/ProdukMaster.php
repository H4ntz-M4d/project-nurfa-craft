<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukMaster extends Model
{
    protected $table = "produk_master";
    protected $primaryKey = "id_master_produk";
    protected $fillable = [
        'id_master_produk',
        'id_ktg_produk',
        'nama_produk',
        'status',
        'slug',
        'deskripsi',
        'meta_keywords',
        'meta_desc',
    ];
    public $timestamps = true;

    public function kategori_produk()
    {
        return $this->belongsTo(KategoriProduk::class,'id_ktg_produk','id_ktg_produk');
    }

    public function variant()
    {
        return $this->hasMany(ProdukVariant::class, 'id_master_produk', 'id_master_produk');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produkMaster) {
            $produkMaster->slug = md5(now()->timestamp);
        });
    }
}
