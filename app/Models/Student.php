<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'roll_no', 'semester', 'department'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
