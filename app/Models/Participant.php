<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'subtest_id',
        'nik',
        'name',
        'is_active',
        'created_by',
        'created_time',
        'updated_by',
        'updated_time',
        'deleted_by',
        'deleted_time',
        'insert_from_query',
        'rank',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function subtest()
    {
        return $this->belongsTo(Subtest::class);
    }
}
