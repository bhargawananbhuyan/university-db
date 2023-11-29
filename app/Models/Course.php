<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'instructor_id'
    ];

    public function exams()
    {
        return $this->hasMany(Exam::class, 'course_id');
    }

    public function students()
    {
        return $this->hasMany(StudentCourse::class, 'course_id');
    }
}
