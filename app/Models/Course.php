<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'credit_hours'];

    public function contents()
    {
        return $this->hasMany(CourseContent::class);
    }
}
