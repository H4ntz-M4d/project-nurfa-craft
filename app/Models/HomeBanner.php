<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
{
    protected $table = 'home_banner';
    protected $primaryKey = 'id_banner';
    protected $fillable = ['gambar', 'judul', 'label'];

    public $timestamps = true;
}
