<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('areas')]
#[Fillable('name', 'code')]


class Area extends Model
{
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
