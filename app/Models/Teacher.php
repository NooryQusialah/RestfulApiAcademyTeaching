<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'expertise',
        'qualification',
        'experience_years',
        'verified',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function courses()
    {
           return $this->belongsToMany(Course::class, 'teacher_course');
    }
}
