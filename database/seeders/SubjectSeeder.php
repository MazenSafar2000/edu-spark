<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->delete();
        $subjects = [
            ['en' => 'Arabic Language', 'ar' => 'لغة عربية'],
            ['en' => 'English Language', 'ar' => 'لغة إنجليزية'],
            ['en' => 'Islamic Education', 'ar' => 'تربية إسلامية'],
            ['en' => 'Science and Life', 'ar' => 'علوم وحياة'],
            ['en' => 'Mathematics', 'ar' => 'رياضيات '],
            ['en' => 'Social Studies', 'ar' => 'دراسات اجتماعية'],
            ['en' => 'Geography of Palestine', 'ar' => 'جغرافية فلسطين'],
            ['en' => 'Technology', 'ar' => 'التكنولوجيا'],
            ['en' => 'Physics', 'ar' => 'فيزياء'],
            ['en' => 'Chemistry', 'ar' => 'كيمياء'],
            ['en' => 'Biology', 'ar' => 'أحياء'],
            ['en' => 'History', 'ar' => 'تاريخ'],
            ['en' => 'Civic and Life Skills Education', 'ar' => 'التربية الوطنية والحياتية'],
            ['en' => 'National and Social Education', 'ar' => 'التنشئة الوطنية والاجتماعية'],
        ];
        foreach ($subjects as $S) {
            Subject::create(['name' => $S]);
        }
    }
}
