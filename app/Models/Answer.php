<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'tr_answers';

    protected $fillable = [
        'project_id',
        'participant_id',
        'question_id',
        'choice_id',
        'choice_type',
        'created_by',
        'created_time',
    ];

    public $timestamps = false; // Since we have custom timestamps
}
