<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MFoodIntake extends Model
{
    use HasFactory;

    protected $table = 'm_food_intake';

    protected $fillable = [
        'm_user_id',
        'recipe_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'm_user_id');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
