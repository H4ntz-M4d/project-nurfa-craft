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
        'jumlah'
    ];

    public function produk_master()
    {
        return $this->belongsTo(ProdukMaster::class,'id_master_produk','id_master_produk');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($keranjang) {
            $keranjang->slug = md5(now()->timestamp);
        });
    }
}
