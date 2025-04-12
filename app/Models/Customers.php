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
        'email',
        'no_telp',
        'alamat',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customers) {
            $customers->slug = md5(now()->timestamp);
        });
    }
}
