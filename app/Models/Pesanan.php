<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $fillable = [
        'id_transaction',
        'status',
        'jasa_pengiriman',
        'no_resi',
        'harga_pengiriman',
        'keterangan',
        'slug',
    ];
    public $timestamps = true;

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'id_transaction', 'id_transaction');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pesanan) {
            $pesanan->slug = md5(now()->valueOf());
        });
    }
}
