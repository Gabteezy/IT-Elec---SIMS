<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'schedule',
        'instructor',
        'grades',
        'student_id'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
