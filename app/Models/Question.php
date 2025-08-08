<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // public function quizze()
    // {
    //     return $this->belongsTo(Exam::class);
    // }

    // public function studentAnswers()
    // {
    //     return $this->hasMany(StudentAnswer::class);
    // }

    public function QCategory()
    {
        return $this->belongsTo(QuestionsCategotry::class, 'QCategory_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_questions')
            ->withPivot('score') // إذا أضفت score في جدول exam_questions
            ->withTimestamps();
    }
}
