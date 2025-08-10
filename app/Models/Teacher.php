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
        return $this->belongsTo(Specialization::class, 'Specialization_id');
    }

    public function genders()
    {
        return $this->belongsTo(Gender::class, 'Gender_id');
    }

    public function sections()
    {
        return $this->hasManyThrough(
            Section::class,
            Teacher_section::class,
            'teacher_id',  // جدول teacher_sections المفتاح الأجنبي للمعلم
            'id',          // جدول sections المفتاح الأساسي
            'id',          // مفتاح المعلم في جدول teachers
            'section_id'   // المفتاح الأجنبي للشعبة في جدول teacher_sections
        );
    }

    public function teacherSections()
    {
        return $this->hasMany(Teacher_section::class, 'teacher_id', 'id');
    }


    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_sections')
            ->withPivot('section_id')
            ->withTimestamps();
    }

    public function questionBanks()
    {
        return $this->hasMany(QuestionsBank::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function libraries()
    {
        return $this->hasMany(Library::class);
    }

    // public function subjectSections()
    // {
    //     return $this->hasMany(Teacher_section::class);
    // }


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
