<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokRecord extends Model
{
    protected $table = 'stok_record';
    protected $primaryKey = 'id_stok_record';
    protected $fillable = [
        'id_user',
        'id_master_produk',
        'id_var_produk',
        'id_detail_produk',
        'stok_awal',
        'stok_masuk',
        'stok_akhir',
        'keterangan',

    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function produkMaster()
    {
        return $this->belongsTo(ProdukMaster::class, 'id_master_produk', 'id_master_produk');
    }

    public function produkVariant()
    {
        return $this->belongsTo(ProdukVariant::class, 'id_var_produk', 'id_var_produk');
    }

    public function detailProduk()
    {
        return $this->belongsTo(DetailProdukMaster::class, 'id_detail_produk', 'id_detail_produk');
    }

    public function getJenisProdukAttribute()
    {
        if ($this->id_var_produk) {
            return 'variant';
        } elseif ($this->id_detail_produk) {
            return 'non-variant';
        }
        return 'unknown';
    }

    public function getNamaLengkapAttribute()
    {
        $nama = $this->produkMaster->nama_produk ?? '';
        
        if ($this->jenis_produk === 'variant' && $this->produkVariant) {
            // Dapatkan kombinasi variant
            $variantValues = $this->produkVariant->variantValues()
                ->with('variantValue')
                ->get()
                ->pluck('variantValue.value')
                ->implode(', ');
            
            $nama .= ' (' . $variantValues . ')';
        }
        
        return $nama;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($stokRecord) {
            $stokRecord->slug = md5(now()->valueOf());
        });
    }
}
