<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivitySystem extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
