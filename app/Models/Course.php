<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'credit_hours', 'semester', 'teacher_id']; 

    public function contents()
    {
        return $this->hasMany(CourseContent::class);
    }

    public function teacher() { 
        return $this->belongsTo(Teacher::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'course_student'); 
    }
}

