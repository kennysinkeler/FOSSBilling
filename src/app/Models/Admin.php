<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements AuthorizableContract
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Authorizable;

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
