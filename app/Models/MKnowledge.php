<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MKnowledge extends Model
{
    use HasFactory;

    protected $table = 'm_knowledge';

    protected $fillable = [
        'title',
        'content',
        'slug',
        'image',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
