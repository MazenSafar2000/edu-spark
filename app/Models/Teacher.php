<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;

class Teacher extends Model
{
    use HasFactory;
    use HasTranslations;
    use Notifiable;

    protected $fillable = [
        'Gender_id',
        'Specialization_id',
        'Joining_Date',
        'Address',
        'user_id',
        'National_ID',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specializations()
    {
        return $this->belongsTo('App\Models\Specialization', 'Specialization_id');
    }

    public function genders()
    {
        return $this->belongsTo('App\Models\Gender', 'Gender_id');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'teacher_sections', 'teacher_id', 'section_id')->distinct();
    }

    public function subjects()
    {
        return $this->hasMany('App\Models\Subject', 'teacher_id');
    }

    public function libraries()
    {
        return $this->hasMany(Library::class);
    }

    public function subjectSections()
    {
        return $this->hasMany(Teacher_section::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function studentAnswers()
    {
        return $this->hasManyThrough(StudentAnswer::class, Exam::class);
    }




    // public function specializations()
    // {
    //     return $this->belongsTo('App\Models\Specialization', 'Specialization_id');
    // }

    // public function genders()
    // {
    //     return $this->belongsTo('App\Models\Gender', 'Gender_id');
    // }

    // public function sections()
    // {
    //     return $this->belongsToMany(Section::class, 'teacher_sections', 'teacher_id', 'section_id')->distinct();
    // }


    // public function subjects()
    // {
    //     return $this->belongsToMany(Subject::class, 'teacher_sections', 'teacher_id', 'subject_id')->distinct();
    // }


    // public function subjectSections()
    // {
    //     return $this->hasMany(Teacher_section::class);
    // }


    // public function libraries()
    // {
    //     return $this->hasMany(Library::class);
    // }
}
