<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrinkLog extends Model
{
    use HasFactory;
    protected $table = 'drink_log';
    protected $fillable = ['user_id', 'drink_name', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
