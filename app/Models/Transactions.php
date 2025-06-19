<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    
    protected $primaryKey = 'id_transaction';

    protected $fillable = [
        'id_user', 'tanggal', 'total', 'status',
        'provinsi', 'kota', 'alamat_pengiriman', 'telepon',
        'order_id', 'snap_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetails::class, 'id_transaction');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            $transaksi->slug = md5(now()->valueOf());
        });
    }
}
