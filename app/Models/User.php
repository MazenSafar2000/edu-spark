<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasTranslations;

    public $translatable = ['name'];


    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'name' => 'array',
    ];

    public function getNameAttribute($value)
    {
        $name = json_decode($value, true);

        if (!is_array($name)) {
            return $value; // Return raw value if decoding fails
        }

        return $name[app()->getLocale()] ?? $name['en'] ?? reset($name);
    }


    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function parents()
    {
        return $this->hasOne(ParentProfile::class);
    }

    public function manager()
    {
        return $this->hasOne(Manager::class);
    }
}
