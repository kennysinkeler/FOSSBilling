<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    use HasFactory;

    /**
     * @return HasOne
     */
    function promo(): HasOne
    {
        return $this->hasOne(Promo::class);
    }

    function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    /**
     * @return HasOne
     */
    function currency(): HasOne
    {
        return $this->hasOne(Currency::class);
    }
}
