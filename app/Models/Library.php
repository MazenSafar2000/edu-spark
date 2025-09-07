<?php

namespace App\Models;

use App\Traits\AttachFilesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;
    use AttachFilesTrait;

    protected $table = "libraries";
    protected $fillable = [
        'id',
        'title',
        'file_name',
        'Grade_id',
        'Classroom_id',
        'section_id',
        'teacher_id',
        'subject_id',
        'created_by_teacher_id',
    ];

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'Grade_id');
    }

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'Classroom_id');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }
}
