<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = [
        'user_id',         //FK
        'product_loan_id', // FK
        'file_path_docx',
        'file_path_pdf',
        'created_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function productLoan(): BelongsTo
    {
        return $this->belongsTo(ProductLoan::class, 'product_loan_id', 'id');
    }
}
