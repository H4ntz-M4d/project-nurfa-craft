<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';
    public $timestamps = true;

    protected $fillable = [
        'kategori_pengeluaran',
        'nama_pengeluaran',
        'tanggal_pengeluaran',
        'jumlah_pengeluaran',
        'keterangan',
        'slug',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($pengeluaran) {
            $pengeluaran->slug = md5(now()->valueOf());
        });
    }
}
