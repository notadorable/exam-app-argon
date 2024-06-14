<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamMap extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'disclaimer_id',
        'disclaimerfinish_id',
        'agreement_id',
        'durasi',
        'is_active',
        'created_by',
        'created_time',
        'updated_by',
        'updated_time',
        'deleted_by',
        'deleted_time',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
