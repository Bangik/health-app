<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $table = 'recipes';
    protected $fillable = [
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
        'image',
    ];

    protected $appends = [
        'image_url',
    ];

    public function foodIntakes()
    {
        return $this->hasMany(MFoodIntake::class, 'recipe_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->timezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }
}
