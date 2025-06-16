<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    protected $fillable = [
        'id_user',
        'id_master_produk',
        'jumlah',
        'status_produk',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function produk_master()
    {
        return $this->belongsTo(ProdukMaster::class,'id_master_produk','id_master_produk');
    }

    public function keranjang_variant()
    {
        return $this->hasMany(KeranjangVariant::class, 'id_keranjang', 'id_keranjang')
            ->with('produk_variant_value.variantAttribute', 'produk_variant_value.variantValues');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($keranjang) {
            $keranjang->slug = md5(now()->timestamp);
        });
    }
}
