<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'brand',
        'model',
        'serial_number',
        'processor',
        'memory',
        'disk',
        'price',
        'price_string',
        'category',
        'fl_available',
    ];

    public function productLoanItem(): HasMany
    {
        return $this->hasMany(ProductLoanItem::class, 'product_id', 'id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'product_id', 'id');
    }

}
