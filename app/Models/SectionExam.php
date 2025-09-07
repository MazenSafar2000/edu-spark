<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionExam extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'exam_id',
        'subject_id',
        'show_answers',
    ];

    public function exams()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    // public function sections()
    // {
    //     return $this->belongsToMany(Section::class, 'exam_section', 'exam_id', 'section_id', 'subject_id')
    //         ->withTimestamps();
    // }
}
