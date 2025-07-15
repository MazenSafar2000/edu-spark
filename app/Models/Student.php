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
        return $this->belongsTo('App\Models\Gender', 'gender_id');
    }

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

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function myparent()
    {
        return $this->belongsTo('App\Models\ParentProfile', 'parent_id');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\Models\Teacher', 'teacher_section', 'section_id', 'teacher_id');
    }

    public function homeworkSubmissions()
    {
        return $this->hasMany(Homework_submission::class);
    }

    public function submissions()
    {
        return $this->hasMany(Homework_submission::class);
    }



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
