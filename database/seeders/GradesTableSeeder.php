<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grades')->delete();
        $grades = [
            ['en'=> 'Primary stage', 'ar'=> 'المرحلة الابتدائية'],
            ['en'=> 'Middle Stage', 'ar'=> 'المرحلة الاعدادية'],
            ['en'=> 'High School Stage', 'ar'=> 'المرحلة الثانوية'],
        ];

        foreach ($grades as $grade) {
            Grade::create(['Name' => $grade]);
        }
    }
}
