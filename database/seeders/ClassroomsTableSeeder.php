<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classrooms = [
            // Primary/Elementary Stage
            ['en' => 'First Grade', 'ar' => 'الصف الأول', 'Grade_id' => 1],
            ['en' => 'Second Grade', 'ar' => 'الصف الثاني', 'Grade_id' => 1],
            ['en' => 'Third Grade', 'ar' => 'الصف الثالث', 'Grade_id' => 1],
            ['en' => 'Fourth Grade', 'ar' => 'الصف الرابع', 'Grade_id' => 1],
            ['en' => 'Fifth Grade', 'ar' => 'الصف الخامس', 'Grade_id' => 1],
            ['en' => 'Sixth Grade', 'ar' => 'الصف السادس', 'Grade_id' => 1],

            // Middle/Preparatory Stage
            ['en' => 'Seventh Grade', 'ar' => 'الصف السابع', 'Grade_id' => 2],
            ['en' => 'Eighth Grade', 'ar' => 'الصف الثامن', 'Grade_id' => 2],
            ['en' => 'Ninth Grade', 'ar' => 'الصف التاسع', 'Grade_id' => 2],

            // Secondary/High School Stage
            ['en' => 'Tenth Grade', 'ar' => 'الصف العاشر', 'Grade_id' => 3],
            ['en' => 'Eleventh Grade', 'ar' => 'الصف الحادي عشر', 'Grade_id' => 3],
            ['en' => 'Twelfth Grade', 'ar' => 'الصف الثاني عشر', 'Grade_id' => 3],
        ];

        foreach ($classrooms as $classroom) {
            DB::table('classrooms')->insert([
                'Name_Class' => json_encode([
                    'en' => $classroom['en'],
                    'ar' => $classroom['ar'],
                ]), // store the classroom names in a JSON format for both languages
                'Grade_id' => $classroom['Grade_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
