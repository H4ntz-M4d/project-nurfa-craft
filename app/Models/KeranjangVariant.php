<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangVariant extends Model
{
    protected $table = 'keranjang_variant';
    protected $primaryKey = 'id_keranjang_variant';
    protected $fillable = [
        'id_keranjang',
        'id_product_variant_value',
    ];

    public function produk_variant_value()
    {
        return $this->belongsTo(ProdukVariantValues::class, 'id_product_variant_value');
    }

}
