<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = [
        'user_id', // FK
        'product_id', // FK
        'invoice_number',
        'file_path'
    ];



    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
