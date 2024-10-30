<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'm_user';

    protected $fillable = [
        'name',
        'username',
        'date_of_birth',
        'education',
        'occupation',
        'duration_of_hypertension',
        'phone_number',
        'gender',
        'note_hypertension',
        'role',
        'fcm_token',
        'token',
        'password',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
    ];

    protected $appends = [
        'age',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->diff(Carbon::now())->format('%y years, %m months, %d days');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function chatWithAdmin($adminId)
    {
        return Message::where(function ($query) use ($adminId) {
                $query->where('sender_id', $this->id)
                    ->where('receiver_id', $adminId);
            })
            ->orWhere(function ($query) use ($adminId) {
                $query->where('sender_id', $adminId)
                    ->where('receiver_id', $this->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function foodIntakes()
    {
        return $this->hasMany(MFoodIntake::class, 'm_user_id', 'id');
    }

    public function drinkLogs()
    {
        return $this->hasMany(DrinkLog::class, 'user_id', 'id');
    }

    public function exerciseLogs()
    {
        return $this->hasMany(MExerciseLog::class, 'm_user_id', 'id');
    }

    public function healthControlNote()
    {
        return $this->hasMany(MHealthControlNote::class, 'm_user_id', 'id');
    }

    public function medicineLogs()
    {
        return $this->hasMany(MedicineLog::class, 'user_id', 'id');
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
