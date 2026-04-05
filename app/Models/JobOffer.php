<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    const TABLE = 'job_offer';

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
}
