<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CartProduct extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * @return HasOne
     */
    function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
