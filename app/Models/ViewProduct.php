<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewProduct extends Model
{
    protected $table = 'logs_view_product';
    protected $primaryKey = 'id_view_product';
    protected $fillable = [
        'id_user',
        'id_master_produk',
    ];

    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function produkmaster()
    {
        return $this->belongsTo(ProdukMaster::class, 'id_master_produk', 'id_master_produk');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($view_product) {
            $view_product->slug = md5(now()->valueOf());
        });
    }
}
