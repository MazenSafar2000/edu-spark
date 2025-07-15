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

    // protected static function booted()
    // {
    //     static::deleting(function ($library) {
    //         if ($library->file_name && $library->teacher && $library->teacher->user) {
    //             $teacherName = $library->teacher->user->name;
    //             $library->deleteFile($teacherName, $library->file_name);
    //         }
    //     });
    // }

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
