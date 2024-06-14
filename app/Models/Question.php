<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'subtest_id',
        'is_grup',
        'question_name',
        'question_detail',
        'is_active',
        'created_by',
        'created_time',
        'updated_by',
        'updated_time',
        'deleted_by',
        'deleted_time',
    ];

    public $timestamps = false;

    public function subtest()
    {
        return $this->belongsTo(Subtest::class);
    }
}
