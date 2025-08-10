<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Classroom extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'Classrooms';
    protected $fillable=['Name_Class','Grade_id'];
    public $translatable = ['Name_Class'];
    protected $casts = [
        'Name_Class' => 'array',
    ];
    public $timestamps = true;


    public function Grades()
    {
        return $this->belongsTo( Grade::class, 'Grade_id');
    }

    public function sections()
    {
        return $this->hasMany( Section::class, 'Class_id');
    }
}
