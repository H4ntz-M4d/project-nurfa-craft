<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukVariantValues extends Model
{
    protected $table = 'produk_variant_values';
    protected $primaryKey = 'id_product_variant_value';
    protected $fillable = ['id_var_produk', 'id_variant_attributes', 'id_variant_value'];
    public $timestamps = true;

    public function produkVariant(){
        return $this->belongsTo(ProdukVariant::class, 'id_var_produk');
    }

    public function variantAttribute(){
        return $this->belongsTo(VariantAttribute::class,'id_variant_attributes');
    }

    public function variantValues(){
        return $this->belongsTo(VariantValues::class,'id_variant_value','id_variant_value');
    }
}
