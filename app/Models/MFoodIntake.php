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
        'food_name',
        'description',
        'food_type',
        'portion',
        'calories',
        'protein',
        'fat',
        'carbohydrate',
        'sugar',
        'cholesterol',
        'mass',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'm_user_id');
    }
}
