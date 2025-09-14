<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class managerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => ['en' => 'mazen abu safar', 'ar' => 'مازن ابو صفر'],
            'email' => 'mazenadmin@gmail.com',
            'password' => Hash::make('mazen1234'),
            'role' => 'manager',
            'National_ID' => '408557494',
        ]);

        $user->manager()->create([
            // 'National_ID' => '408557494',
            'user_id' => $user->id,
        ]);
    }
}
