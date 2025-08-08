<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['Name_Section'];
    protected $fillable = ['Name_Section', 'Grade_id', 'Class_id', 'Status'];
    protected $table = 'sections';
    protected $casts = [
        'Name_Section' => 'array',
    ];
    public $timestamps = true;


    public function My_classs()
    {
        return $this->belongsTo('App\Models\Classroom', 'Class_id');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\Models\Teacher', 'teacher_sections');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'section_id');
    }

    public function teacherSections()
    {
        return $this->hasMany(Teacher_section::class);
    }

    // public function exams()
    // {
    //     return $this->hasMany(Exam::class);
    // }
    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'section_exams')->withTimestamps();
    }
}
