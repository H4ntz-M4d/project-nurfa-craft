<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Casts\CleanHtml;

class Blog extends Model
{
    protected $table = 'blog';

    protected $primaryKey = 'id_blog';

    protected $fillable = [
        'id_user',
        'judul',
        'deskripsi',
        'gambar',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'judul' => CleanHtml::class, // cleans both when getting and setting the value
        'deskripsi' => CleanHtml::class, // cleans both when getting and setting the value
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
