<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestions extends Model
{
    use HasFactory;
    protected $fillable = [
        "exam_id",
        "question_id",
        "score",
    ];

    // public function exam()
    // {
    //     return $this->belongsTo(Exam::class);
    // }

    // public function question()
    // {
    //     return $this->belongsTo(Question::class);
    // }
}
