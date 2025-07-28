<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductLoanItem extends Model
{
    protected $table = 'product_loan_items';

    protected $fillable =
        [
            'product_loan_id', //FK
            'product_id', // FK
            'returned_at'
        ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function productLoan(): BelongsTo
    {

        return $this->belongsTo(ProductLoan::class, 'product_loan_id', 'id');
    }
}
