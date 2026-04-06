<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\User;

class Employee extends Model
{
    const TABLE = 'employee';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
