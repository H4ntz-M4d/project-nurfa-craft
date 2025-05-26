<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    protected $table = 'transaction_details';

    protected $primaryKey = 'id_transaction_detail';

    protected $fillable = [
        'id_transaction', 'id_master_produk', 'jumlah', 'harga'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'id_transaction');
    }

    public function produk()
    {
        return $this->belongsTo(ProdukMaster::class, 'id_master_produk');
    }

    public function variants()
    {
        return $this->hasMany(TransactionDetailVariants::class, 'id_transaction_detail');
    }
}
