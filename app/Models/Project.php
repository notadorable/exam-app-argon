<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'project_description',
        'is_active',
        'created_by',
        'created_time',
        'updated_by',
        'updated_time',
        'deleted_by',
        'deleted_time',
    ];

    public $timestamps = false;

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function mapping()
    {
        return $this->hasMany(Mapping::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
