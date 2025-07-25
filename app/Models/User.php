<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_CUSTOMER = 'customers';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'slug',
    ];

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id_user', 'id');
    }
    public function customers()
    {
        return $this->hasOne(Customers::class, 'id_user', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customers) {
            $customers->slug = md5(now()->timestamp);
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
