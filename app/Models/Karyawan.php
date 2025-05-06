<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'nama',
        'email',
        'jkel',
        'no_telp',
        'alamat',
        'tempat_lahir',
        'tgl_lahir',
        'slug'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($karyawan) {
            $karyawan->slug = md5(now()->timestamp);
        });
    }

}
