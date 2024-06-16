<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'subtest_id',
        'durasi',
        'is_active',
        'created_by',
        'created_time',
        'updated_by',
        'updated_time',
        'deleted_by',
        'deleted_time',
    ];

    public $timestamps = false; // Disable timestamps
}
