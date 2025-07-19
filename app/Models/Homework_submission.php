<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework_submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'homework_id',
        'student_id',
        'file_path',
        'notes',
        'submitted_at',
        'status',
        'degree',
        'feedback',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function homework()
    {
        return $this->belongsTo(Homework::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
