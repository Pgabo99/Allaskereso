<?php

namespace App\Models;

use App\EmployeeRoleEnum;
use Illuminate\Support\Facades\Auth;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Builder;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;

class Company extends Model
{
    protected $table = 'company';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'contact_email',
        'location',
        'tax_id',
        'created_by',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'company_id');
    }

    protected $appends = ['is_own_company', 'can_edit_company', 'can_create_job_offers', 'can_handle_applications'];

    public function getIsOwnCompanyAttribute(): bool
    {
        return Auth::user()->getAuthIdentifier() === $this->user->getKey();
    }

    public function getCanEditCompanyAttribute(): bool
    {
        return Auth::user()->isAdmin()
            || $this->getIsOwnCompanyAttribute()
            || $this->employees()
                ->where('user_id', Auth::id())
                ->where('rights', EmployeeRoleEnum::EDIT_COMPANY_DATA->value)
                ->exists();
    }

    public function getCanCreateJobOffersAttribute(): bool
    {
        return Auth::user()->isAdmin()
            || $this->getIsOwnCompanyAttribute()
            || $this->employees()
                ->where('user_id', Auth::id())
                ->where('rights', EmployeeRoleEnum::EDIT_COMPANY_DATA->value)
                ->exists();
    }

    public function getCanHandleApplicationsAttribute(): bool
    {
        return Auth::user()->isAdmin()
            || $this->getIsOwnCompanyAttribute()
            || $this->employees()
                ->where('user_id', Auth::id())
                ->where('rights', EmployeeRoleEnum::HANDLE_APPLICATIONS->value)
                ->exists();
    }

    public function scopeUserCompanies(Builder $query): Builder
    {
        $employeeCompanyIds = Employee::where('user_id', Auth::id())->pluck('company_id');

        return $query->when(!Auth::user()->isAdmin(), function (Builder $query) use ($employeeCompanyIds) {
            return $query ->where(function ($query) use ($employeeCompanyIds) {
                $query->where('created_by', Auth::id())
                    ->orWhereIn('_id', $employeeCompanyIds);
            });
        });
    }
}
