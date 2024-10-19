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
}
