<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsBank extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id'];
    protected $table = 'questions_banks';

    public function categories()
    {
        return $this->hasMany(QuestionsCategotry::class, 'questions_bank_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
