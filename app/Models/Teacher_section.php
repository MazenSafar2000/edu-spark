<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher_section extends Model
{
    use HasFactory;


    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    // public function subject()
    // {
    //     return $this->belongsTo(Subject::class);
    // }

    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class);
    // }

    // public function questionsBanks()
    // {
    //     return $this->hasMany(QuestionsBank::class);
    // }

    // public function exams()
    // {
    //     return $this->belongsToMany(SectionExam::class, 'section_exams', 'section_id', 'exam_id', 'subject_id')
    //         ->withTimestamps();
    // }
}
