<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'teacher_id',
        'description',
        'due_date',
        'assignment_file',
        'submission_file',
    ];

    // Relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship with Teacher (User)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
