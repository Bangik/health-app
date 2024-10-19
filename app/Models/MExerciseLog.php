<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MExerciseLog extends Model
{
    use HasFactory;

    protected $table = 'm_exercise_log';

    protected $fillable = [
        'm_user_id',
        'm_exercise_id',
        'description',
        'duration',
        'calories',
        'distance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'm_user_id');
    }

    public function exercise()
    {
        return $this->belongsTo(MExercise::class, 'm_exercise_id');
    }
}
