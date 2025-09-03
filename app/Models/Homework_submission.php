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
        'delivery_status',
        'evaluation_status',
        'degree',
        'feedback',
        'show_grade',
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
