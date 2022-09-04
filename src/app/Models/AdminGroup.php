<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    function admin(){
        return $this->hasMany(Admin::class);
    }
}
