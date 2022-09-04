<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Session extends Model
{
    use HasFactory;

    /**
     * @return HasOne
     */
    function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }
}
