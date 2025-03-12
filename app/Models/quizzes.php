<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class quizzes extends Model
{
    protected $fillable = ['user_id', 'category_id', 'title', 'description'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(categories::class);
    }

    public function questions() {
        return $this->hasMany(questions::class);
    }
}
