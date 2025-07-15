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
        'duration',
        'subject_id',
        'grade_id',
        'classroom_id',
        'section_id',
        'teacher_id',
        'start_at',
        'end_at',
        'created_by_teacher_id',
    ];

    public $translatable = ['name'];

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id');
    }

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'classroom_id');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }

    public function degree()
    {
        return $this->hasMany('App\Models\Degree');
    }
}
