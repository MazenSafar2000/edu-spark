<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Graduate extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'graduates';
    protected $fillable = [
        'student_id',
        'user_id',
        'name',
        'email',
        'National_ID',
        'parent_name',
        'grade',
        'classroom',
        'section',
        'academic_year',
        'Date_Birth',
        'graduated_at',
        'reason',
    ];

    public $translatable = [
        'name',
        'parent_name',
        'grade',
        'classroom',
        'section'
    ];
    protected $casts = [
        'name' => 'array',
        'parent_name' => 'array',
        'grade' => 'array',
        'classroom' => 'array',
        'section' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
