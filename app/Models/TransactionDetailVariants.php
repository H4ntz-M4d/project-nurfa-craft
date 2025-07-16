<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetailVariants extends Model
{
    protected $table = 'transaction_detail_variants';
    
    protected $fillable = [
        'id_transaction_detail', 'nama_atribut', 'nilai_variant'
    ];

    public function detail()
    {
        return $this->belongsTo(TransactionDetails::class, 'id_transaction_detail');
    }
}
