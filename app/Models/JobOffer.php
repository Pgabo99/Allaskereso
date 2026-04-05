<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobOffer extends Model
{
    const TABLE = 'job_offer';
    use Notifiable;

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
