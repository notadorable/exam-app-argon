<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtest extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'formula_id',
        'subtest_name',
        'is_active',
        'duration',
        'created_by',
        'created_time',
        'updated_by',
        'updated_time',
        'deleted_by',
        'deleted_time',
    ];

    public $timestamps = false;

    public function questions()
    {
        return $this->hasMany(Question::class, 'subtest_id');
    }
}
