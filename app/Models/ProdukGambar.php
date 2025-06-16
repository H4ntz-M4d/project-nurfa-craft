<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukGambar extends Model
{
    protected $table = 'produk_gambar';
    protected $primaryKey = 'id_produk_gambar';
    public $timestamps = true;

    protected $fillable = [
        'id_master_produk',
        'gambar',
    ];

    public function masterProduk()
    {
        return $this->belongsTo(ProdukMaster::class, 'id_master_produk', 'id_master_produk');
    }

}
