<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionsCategotry extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'questions_bank_id'];
    protected $table = 'questions_categories' ;


    public function bank()
    {
        return $this->belongsTo(QuestionsBank::class, 'questions_bank_id');
    }
}
