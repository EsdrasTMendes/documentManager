<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'category_id'
    ];

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function productLoanItem(): HasMany
    {
        return $this->hasMany(ProductLoanItem::class, 'product_id', 'id');
    }

}
