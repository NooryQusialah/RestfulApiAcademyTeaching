<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Teacher extends Model
{
    use HasApiTokens, HasFactory,HasRoles,Notifiable;

    protected $fillable = [
        'user_id',
        'expertise',
        'qualification',
        'experience_years',
        'verified',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'teacher_course');
    }
}
