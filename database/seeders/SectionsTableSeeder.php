<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsTableSeeder extends Seeder
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
            ['Class_ids' => [1, 2, 3, 4, 5, 6]],

            // Middle/Preparatory Stage
            ['Class_ids' => [7, 8, 9]],

            // Secondary/High School Stage
            ['Class_ids' => [10, 11, 12]],
        ];

        foreach ($classrooms as $classroom) {
            foreach ($classroom['Class_ids'] as $class_id) {
                // Insert Section A and Section B for each class
                DB::table('sections')->insert([
                    'Name_Section' => json_encode(['en' => 'A', 'ar' => 'أ']),
                    'Status' => 1, // Assuming 1 means active
                    'Class_id' => $class_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('sections')->insert([
                    'Name_Section' => json_encode(['en' => 'B', 'ar' => 'ب']),
                    'Status' => 1, // Assuming 1 means active
                    'Class_id' => $class_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
