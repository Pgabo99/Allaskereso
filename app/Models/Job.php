<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\DocumentModel;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    use DocumentModel;
    protected $table = 'job';
    protected $fillable = [
        'parent_job',
        'title',
    ];

    public $casts = [
        'created_time' => 'datetime',
        'modified_time' => 'datetime',
        'last_activity_date' => 'datetime',
        'deleted' => 'int',
    ];

}
