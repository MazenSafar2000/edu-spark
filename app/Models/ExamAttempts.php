<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempts extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'attempt_number',
        'current_question_index',
        'time_left',
        'status',
        'started_at',
        'deadline_at',
        'ended_at',
        'score_obtained',
        'grade_obtained',
        'question_order'
        // 'score',
        // 'final_grade',
        // 'correct_answers',
        // 'started_at',
        // 'ended_at'
    ];

    protected $casts = [
        'question_order' => 'array', // or 'json'
        'started_at'     => 'datetime',
        'deadline_at'    => 'datetime',
        'ended_at'       => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentExamAnswers::class, 'attempt_id');
    }
}
