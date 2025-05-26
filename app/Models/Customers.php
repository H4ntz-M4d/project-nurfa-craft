<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customers';

    public $timestamps = true;

    protected $fillable =
    [
        'id_user',
        'nama',
        'no_telp',
        'jkel',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customers) {
            $customers->slug = md5(now()->timestamp);
        });
    }
}
