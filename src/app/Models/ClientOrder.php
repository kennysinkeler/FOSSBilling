<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientOrder extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return HasMany
     */
    function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    function form(){
        return $this->
    }
}
