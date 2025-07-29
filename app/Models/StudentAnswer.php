<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_exam_session_id',
        'question_id',
        'answer',
        'is_correct',
    ];

    public function studentExamSession()
    {
        return $this->belongsTo(StudentExamSession::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
