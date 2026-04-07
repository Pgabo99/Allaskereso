<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class Application extends Model
{
    protected $table = 'application';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'job_offer_id',
        'cv',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jobOffer(): BelongsTo
    {
        return $this->belongsTo(JobOffer::class, 'job_offer_id');
    }
}
