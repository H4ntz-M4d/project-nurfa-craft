<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetailVariants extends Model
{
    protected $table = 'transaction_detail_variants';
    
    protected $fillable = [
        'id_transaction_detail', 'id_variant_attributes', 'id_variant_value'
    ];

    public function detail()
    {
        return $this->belongsTo(TransactionDetails::class, 'id_transaction_detail');
    }

    public function attribute()
    {
        return $this->belongsTo(VariantAttribute::class, 'id_variant_attributes');
    }

    public function value()
    {
        return $this->belongsTo(VariantValues::class, 'id_variant_value');
    }
}
