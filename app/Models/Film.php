<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    protected $fillable = [
        'title',
        'release_year',
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
