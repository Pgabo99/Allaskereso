<?php

namespace App\Models;

use App\EmployeeRoleEnum;
use Illuminate\Support\Arr;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class Employee extends Model
{
    protected $table = 'employee';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'company_id',
        'rights',
    ];

    protected $appends = ['has_right_to_edit_company_data', 'has_right_to_create_job_offers', 'has_right_to_handle_applications'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getHasRightToEditCompanyDataAttribute(): bool
    {
        return Arr::has($this->rights, EmployeeRoleEnum::EDIT_COMPANY_DATA->name);
    }

    public function getHasRightToCreateJobOffersAttribute(): bool
    {
        return Arr::has($this->rights, EmployeeRoleEnum::CREATE_JOB_OFFER->name);
    }

    public function getHasRightToHandleApplicationsAttribute(): bool
    {
        return Arr::has($this->rights, EmployeeRoleEnum::HANDLE_APPLICATIONS->name);
    }
}
