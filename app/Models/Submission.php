<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('submissions')]
#[Fillable('task_id', 'dealer_id', 'link_drive', 'note', 'status', 'supervisor_note', 'submitted_at')]
class Submission extends Model
{
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(SubmissionLog::class);
    }
}