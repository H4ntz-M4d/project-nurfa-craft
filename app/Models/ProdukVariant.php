<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukVariant extends Model
{
    protected $table = "produk_variant";
    protected $primaryKey = "id_var_produk";
    protected $fillable = [
        'id_master_produk',
        'sku',
        'harga',
        'stok',
        'status',
        'slug'
    ];
    public $timestamps = true;

    public function produkMaster()
    {
        return $this->belongsTo(ProdukMaster::class, 'id_master_produk');
    }

    public function variantValues()
    {
        return $this->hasMany(ProdukVariantValues::class, 'id_var_produk', 'id_var_produk');
    }

    public function stokRecords()
    {
        return $this->hasMany(StokRecord::class, 'id_var_produk', 'id_var_produk');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produk_variant) {
            $produk_variant->slug = md5(now()->valueOf());
        });
    }
}
