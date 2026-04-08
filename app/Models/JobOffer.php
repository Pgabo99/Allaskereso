<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class JobOffer extends Model
{
    protected $table = 'job_offer';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'title',
        'description',
        'salary_min',
        'salary_max',
        'location',
        'work_mode',
        'job_id',
    ];

    protected $appends = ['has_right_to_edit'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function getHasRightToEditAttribute(): bool
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return true;
        }

        $company = $this->company;

        if ($company->is_own_company || $company->can_create_job_offers) {
            return true;
        }

        return false;
    }
}
