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



    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'National_ID',
    ];

    public $translatable = ['name'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'name' => 'array',
    ];

    public function username()
    {
        return 'National_ID';
    }

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

    public function allowedChatUsers()
    {
        switch ($this->role) {
            case 'teacher':
                // الطلاب في الأقسام اللي بيدرسها المعلم
                $studentUsers = User::whereHas('student', function ($q) {
                    $q->whereIn('section_id', $this->teacher->sections()->pluck('sections.id'));
                });

                // أولياء أمور هؤلاء الطلاب
                $parentUsers = User::whereHas('parents.students', function ($q) {
                    $q->whereIn('section_id', $this->teacher->sections()->pluck('sections.id'));
                });

                // المديرين
                $managerUsers = User::where('role', 'manager');

                return $studentUsers->union($parentUsers)->union($managerUsers)->get();

            case 'student':
                // المعلمين اللي بيدرسوا هذا الطالب
                $teacherUsers = User::whereHas('teacher.sections', function ($q) {
                    $q->where('sections.id', $this->student->section_id);
                });

                // المديرين
                $managerUsers = User::where('role', 'manager');

                return $teacherUsers->union($managerUsers)->get();

            case 'parent':
                // المعلمين اللي بيدرسوا أولاد هذا الأب/الأم
                $teacherUsers = User::whereHas('teacher.sections', function ($q) {
                    $q->whereIn('sections.id', $this->parents->students->pluck('section_id'));
                });

                // المديرين
                $managerUsers = User::where('role', 'manager');

                return $teacherUsers->union($managerUsers)->get();

            case 'manager':
                return User::all();
        }
    }
}
