<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Grade extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['Name'];
    protected $fillable = ['Name', 'Notes'];
    protected $casts = [
        'Name' => 'array', // or 'json'
    ];
    protected $table = 'Grades';
    public $timestamps = true;

    public function Classrooms()
    {
        return $this->hasMany(Classroom::class,'Grade_id');
    }
}
