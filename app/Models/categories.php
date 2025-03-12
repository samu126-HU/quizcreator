<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    protected $fillable = ['name'];

    public function quizzes()
    {
        return $this->hasMany(quizzes::class);
    }
}
