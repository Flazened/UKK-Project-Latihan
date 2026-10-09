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
    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

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

    public function canBeResubmitted(): bool
    {
        if (in_array($this->status, ['DISETUJUI', 'DITOLAK'])) {
            return false;
        }

        if ($this->task->due_at && now()->startOfDay()->gt($this->task->due_at)) {
            return false;
        }

        return true;
    }
}
