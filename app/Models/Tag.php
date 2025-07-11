<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['name','created_at','updated_at'];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class,'lesson_tags');
    }
}
