<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassIt extends Model
{

    use SoftDeletes;

    protected $table = 'class_its';

    protected $fillable = [
        'title',
        'description',
        'mentor',
        'participant',
        'start_time'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
