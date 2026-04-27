<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    protected $fillable = [
        'student_id',
        'professor_id',
        'subject',
        'semester',
        'academic_year',
        'status',
    ];

    protected $casts = [
        'student_id' => 'integer',
        'professor_id' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function professor()
    {
        return $this->belongsTo(Employee::class, 'professor_id', 'id');
    }
}
