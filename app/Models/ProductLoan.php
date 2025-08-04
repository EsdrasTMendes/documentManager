<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductLoan extends Model
{
    protected $table = 'product_loans';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', // FK
        'loan_date',
        'expected_return_date',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function productLoanItems(): HasMany
    {
        return $this->hasMany(ProductLoanItem::class, 'product_loan_id', 'id');
    }

    /**
     * Define a relação com os documentos de empréstimo.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'product_loan_id', 'id');
    }
}
