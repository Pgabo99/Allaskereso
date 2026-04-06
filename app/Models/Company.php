<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Company extends Model
{
    const TABLE = 'company';

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
}
