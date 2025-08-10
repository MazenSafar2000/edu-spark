<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Exam extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
        'duration',
        'attemptes',
        'question_per_page',
        'total_marks',
        'maximum_grade',
        'shuffle_questions',
        'subject_id',
        'teacher_id',
        'show_answers',
    ];

    public $translatable = ['name'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions')
            ->withPivot('score')
            ->withTimestamps();
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_exams')
            ->withTimestamps();
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempts::class);
    }

    public function sectionExams()
    {
        return $this->hasMany(SectionExam::class);
    }




    // public function degree()
    // {
    //     return $this->hasMany(Degree::class);
    // }

    // public function questions()
    // {
    //     return $this->hasMany(Question::class);
    // }

    // public function studentExamSessions()
    // {
    //     return $this->hasMany(StudentExamSession::class);
    // }

    // public function students()
    // {
    //     return $this->belongsToMany(Student::class, 'student_exam_sessions')
    //         ->withPivot('started_at', 'finished_at');
    // }


}
