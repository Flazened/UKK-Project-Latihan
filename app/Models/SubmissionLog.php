<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('submission_logs')]
#[Fillable('submission_id', 'activity', 'note')]
class SubmissionLog extends Model
{
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }
}