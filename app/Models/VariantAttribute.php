<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantAttribute extends Model
{
    protected $table = "variant_attributes";
    protected $primaryKey = "id_variant_attributes";
    protected $fillable = [
        'nama_variant',
        'slug',
    ];
    public $timestamps = true;

    public function values()
    {
        return $this->hasMany(VariantValues::class, 'id_variant_attributes', 'id_variant_attributes');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($variant_attribute) {
            $variant_attribute->slug = md5(now()->timestamp);
        });
    }
}
