<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([GradesTableSeeder::class]);
        $this->call([ClassroomsTableSeeder::class]);
        $this->call([SectionsTableSeeder::class]);
        $this->call([GenderTableSeeder::class]);
        $this->call([SpecializationsTableSeeder::class]);
        $this->call([SubjectSeeder::class]);
        $this->call([managerSeeder::class]);
        $this->call([parentSeeder::class]);
        $this->call([studentSeeder::class]);
        $this->call([teacherSeeder::class]);
    }
}
