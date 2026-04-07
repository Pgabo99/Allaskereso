<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\DocumentModel;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    use DocumentModel;
    protected $table = 'job';
    protected $fillable = [
        'parent_job',
        'title',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'parent_job');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Job::class, 'parent_job');
    }

    public function JobOffer(): HasMany
    {
        return $this->hasMany(JobOffer::class, 'job_id');
    }
}
