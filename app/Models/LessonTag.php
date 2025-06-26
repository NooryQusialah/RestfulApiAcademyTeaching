<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonTag extends Model
{

    use HasFactory;
    protected $fillable = [
        'lesson_id',
        'tag_id',
    ];
}
