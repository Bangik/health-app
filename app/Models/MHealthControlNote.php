<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MHealthControlNote extends Model
{
    use HasFactory;

    protected $table = 'm_health_control_note';

    protected $fillable = [
        'm_user_id',
        'systolic_pressure',
        'diastolic_pressure',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'm_user_id');
    }
}
