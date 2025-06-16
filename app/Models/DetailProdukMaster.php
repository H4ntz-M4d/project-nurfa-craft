<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailProdukMaster extends Model
{
    protected $table = 'detail_produk_master';
    protected $primaryKey = 'id_detail_produk';
    public $timestamps = false;

    protected $fillable = [
        'id_master_produk',
        'harga',
        'stok',
        'sku',
        'slug'
    ];

    public function produkMaster()
    {
        return $this->belongsTo(ProdukMaster::class, 'id_master_produk', 'id_master_produk');
    }

    public function stokRecords()
    {
        return $this->hasMany(StokRecord::class, 'id_master_produk', 'id_master_produk');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($detailProdukMaster) {
            $detailProdukMaster->slug = md5(now()->timestamp);
        });
    }
}
