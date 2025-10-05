<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'enrollment_number',
        'level',
        'major',
        'date_of_birth',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
        public function courses()
        {
            return $this->belongsToMany(Course::class, 'student_course');
        }
    }
