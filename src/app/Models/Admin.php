<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    /**
     * @return HasMany
     */
    function activityHistory(): HasMany
    {
        return $this->hasMany(ActivityAdminHistory::class);
    }

    /**
     * @return HasMany
     */
    function activitySystem(): HasMany
    {
        return $this->hasMany(ActivitySystem::class);
    }

    /**
     * @return BelongsTo
     */
    function group(): BelongsTo
    {
        return $this->belongsTo(AdminGroup::class);
    }

}
