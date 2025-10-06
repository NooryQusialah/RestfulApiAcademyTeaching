<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [

        'title',
        'description',
        'thumbnail',
        'price',
        'category',
        'level',
        'status',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
        public function teachers()
        {
            return $this->belongsToMany(Teacher::class, 'teacher_course');
        }

        public function students()
        {
            return $this->belongsToMany(Student::class, 'student_course');
        }
}
