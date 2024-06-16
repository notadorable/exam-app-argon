<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';
    protected $fillable = [
        'project_id',
        'participant_id',
        'nik',
        'name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'status_test',
        'access_time',
        'is_active',
        'is_packted',
        'packted_time',
        'created_by',
        'created_time',
        'updated_by',
        'updated_time',
        'deleted_by',
        'deleted_time',
        'finish_time',
        'finish_type',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
