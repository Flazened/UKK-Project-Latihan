<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('tasks')]
#[Fillable('title', 'asigner', 'due_at', 'department_id', 'area_id')]

class Task extends Model
{
    
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function submmissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
