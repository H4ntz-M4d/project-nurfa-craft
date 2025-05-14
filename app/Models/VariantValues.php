<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantValues extends Model
{
    protected $table = "variant_values";
    protected $primaryKey = "id_variant_value";
    protected $fillable = [
        'id_variant_attributes',
        'value',
    ];
    public $timestamps = true;
    
    public function variantAttribute()
    {
        return $this->belongsTo(VariantAttribute::class, 'id_variant_attributes', 'id_variant_attributes');
    }
}
