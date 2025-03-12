<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class questions extends Model
{
    protected $fillable = ['quiz_id', 'question_text', 'answers_json', 'correct_answer'];

    protected $casts = [
        'answers_json' => 'array',
    ];

    public function quiz()
    {
        return $this->belongsTo(quizzes::class);
    }
}
