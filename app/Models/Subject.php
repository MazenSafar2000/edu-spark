<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Subject extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['name'];
    protected $fillable = [
        'name',
        'image'
    ];
    protected $table = 'subjects';
    protected $casts = [
        'name' => 'array',
    ];

    // public function grade()
    // {
    //     return $this->belongsTo('App\Models\Grade', 'grade_id');
    // }

    // public function classroom()
    // {
    //     return $this->belongsTo('App\Models\Classroom', 'classroom_id');
    // }

    // public function teacher()
    // {
    //     return $this->belongsTo('App\Models\Teacher', 'teacher_id');
    // }

    // public function books()
    // {
    //     return $this->hasMany(Library::class);
    // }

    // public function homeworks()
    // {
    //     return $this->hasMany(Homework::class);
    // }

    // public function exams()
    // {
    //     return $this->hasMany(Exam::class);
    // }
}
