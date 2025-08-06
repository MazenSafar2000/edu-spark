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
        'total_degree',
        'subject_id',
        'teacher_id',
        'show_answers',
    ];

    public $translatable = ['name'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function degree()
    {
        return $this->hasMany(Degree::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function studentExamSessions()
    {
        return $this->hasMany(StudentExamSession::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_exam_sessions')
            ->withPivot('started_at', 'finished_at');
    }
}
