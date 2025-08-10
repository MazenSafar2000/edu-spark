<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'National_ID',
        'gender_id',
        'Date_Birth',
        'Grade_id',
        'Classroom_id',
        'section_id',
        'parent_id',
        'academic_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'Grade_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'Classroom_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function myparent()
    {
        return $this->belongsTo(ParentProfile::class);
    }

    public function teachers()
    {
        return $this->belongsToMany('App\Models\Teacher', 'teacher_section', 'section_id', 'teacher_id');
    }


    // Homework
    public function homeworkSubmissions()
    {
        return $this->hasMany(Homework_submission::class);
    }

    public function submissions()
    {
        return $this->hasMany(Homework_submission::class);
    }

    // Exams
    public function examAttempts()
    {
        return $this->hasMany(ExamAttempts::class);
    }


    // exam process relasinshib
    // public function studentExamSessions()
    // {
    //     return $this->hasMany(StudentExamSession::class);
    // }

    public function degrees()
    {
        return $this->hasMany(Degree::class);
    }

    // public function answers()
    // {
    //     return $this->hasManyThrough(StudentAnswer::class, StudentExamSession::class);
    // }

    // public function exams()
    // {
    //     return $this->belongsToMany(Exam::class, 'student_exam_sessions')
    //         ->withPivot('started_at', 'finished_at');
    // }
    // end exam process relasinshib



    protected static function booted()
    {
        static::deleting(function ($student) {
            foreach ($student->images as $image) {
                Storage::disk('upload_attachments')->delete('attachments/students/' . $student->name['en'] . '/' . $image->filename);
            }

            $student->images()->delete();
        });
    }
}
