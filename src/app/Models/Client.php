<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Client extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    function activityEmail(): HasMany
    {
        return $this->hasMany(ActivityClientEmail::class);
    }

    /**
     * @return HasMany
     */
    function activitySystem(): HasMany
    {
        return $this->hasMany(ActivitySystem::class);
    }

    /**
     * @return HasMany
     */
    function balance(): HasMany
    {
        return $this->hasMany(ClientBalance::class);
    }

    function group(): BelongsTo
    {
        return $this->belongsTo(ClientGroup::class);
    }
    function order(){
        return $this->hasMany(ClientOrder::class);
    }
}
