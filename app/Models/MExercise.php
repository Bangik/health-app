<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MExercise extends Model
{
    use HasFactory;

    protected $table = 'm_exercise';

    protected $fillable = [
        'exercise_name',
        'description',
    ];
}
