<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graduate extends Model
{
    use HasFactory;

    protected $table = 'graduates';
    protected $fillable = [
        'student_id',
        'user_id',
        'grade_id',
        'classroom_id',
        'section_id',
        'academic_year',
        'graduated_at',
        'reason',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
