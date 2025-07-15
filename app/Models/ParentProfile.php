<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;

class ParentProfile extends Model
{
    use HasFactory;
    use HasTranslations;
    use Notifiable;

    protected $table = 'parents';
    protected $fillable = [
        'user_id',
        'National_ID',
        'Phone_Father',
        'Job_Father',
        'Address_Father',
    ];
    public $translatable = [
        'Job_Father'
    ];
    protected $casts = [
        'Job_Father' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
