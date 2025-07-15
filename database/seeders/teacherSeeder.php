<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class teacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->delete();
        DB::table('users')->where('role', 'teacher')->delete(); // Optional: remove old teacher users

        $teachers = [
            ['email' => 'ahmed1@example.com', 'name' => ['en' => 'Ahmed Ahmed', 'ar' => 'أحمد أحمد'], 'National_ID' => '123456789', 'Specialization_id' => 1, 'Gender_id' => 1, 'Joining_Date' => '2023-01-01', 'Address' => 'Cairo, Egypt'],
            ['email' => 'ahmed2@example.com', 'name' => ['en' => 'Ahmed Ali', 'ar' => 'أحمد علي'], 'National_ID' => '789456132', 'Specialization_id' => 1, 'Gender_id' => 1, 'Joining_Date' => '2023-02-01', 'Address' => 'Giza, Egypt'],
            ['email' => 'ahmed3@example.com', 'name' => ['en' => 'Ahmed Hassan', 'ar' => 'أحمد حسن'], 'National_ID' => '147852369', 'Specialization_id' => 1, 'Gender_id' => 1, 'Joining_Date' => '2023-03-01', 'Address' => 'Alexandria, Egypt'],
            ['email' => 'ali1@example.com', 'name' => ['en' => 'Ali Ali', 'ar' => 'علي علي'], 'National_ID' => '159753698', 'Specialization_id' => 2, 'Gender_id' => 1, 'Joining_Date' => '2023-04-01', 'Address' => 'Riyadh, Saudi Arabia'],
            ['email' => 'ali2@example.com', 'name' => ['en' => 'Ali Hassan', 'ar' => 'علي حسن'], 'National_ID' => '75365478', 'Specialization_id' => 2, 'Gender_id' => 1, 'Joining_Date' => '2023-05-01', 'Address' => 'Jeddah, Saudi Arabia'],
            ['email' => 'ali3@example.com', 'name' => ['en' => 'Ali Omar', 'ar' => 'علي عمر'], 'National_ID' => '759569569', 'Specialization_id' => 2, 'Gender_id' => 1, 'Joining_Date' => '2023-06-01', 'Address' => 'Dubai, UAE'],
            ['email' => 'mohamed1@example.com', 'name' => ['en' => 'Mohamed Mohamed', 'ar' => 'محمد محمد'], 'National_ID' => '789531567', 'Specialization_id' => 3, 'Gender_id' => 1, 'Joining_Date' => '2023-07-01', 'Address' => 'Abu Dhabi, UAE'],
            ['email' => 'mohamed2@example.com', 'name' => ['en' => 'Mohamed Saeed', 'ar' => 'محمد سعيد'], 'National_ID' => '156345975', 'Specialization_id' => 3, 'Gender_id' => 1, 'Joining_Date' => '2023-08-01', 'Address' => 'Manama, Bahrain'],
            ['email' => 'khalid1@example.com', 'name' => ['en' => 'Khalid Khalid', 'ar' => 'خالد خالد'], 'National_ID' => '558822645', 'Specialization_id' => '4', 'Gender_id' => 1, 'Joining_Date' => '2023-09-01', 'Address' => 'Muscat, Oman'],
            ['email' => 'omar1@example.com', 'name' => ['en' => 'Omar Omar', 'ar' => 'عمر عمر'], 'National_ID' => '958756324', 'Specialization_id' => 5, 'Gender_id' => 1, 'Joining_Date' => '2023-10-01', 'Address' => 'Doha, Qatar'],
            ['email' => 'hassan1@example.com', 'name' => ['en' => 'Hassan Hassan', 'ar' => 'حسن حسن'], 'National_ID' => '753654268', 'Specialization_id' => 5, 'Gender_id' => 1, 'Joining_Date' => '2023-11-01', 'Address' => 'Kuwait City, Kuwait'],
            ['email' => 'saeed1@example.com', 'name' => ['en' => 'Saeed Saeed', 'ar' => 'سعيد سعيد'], 'National_ID' => '985364258', 'Specialization_id' => 6, 'Gender_id' => 1, 'Joining_Date' => '2023-12-01', 'Address' => 'Amman, Jordan'],
            ['email' => 'nader1@example.com', 'name' => ['en' => 'Nader Nader', 'ar' => 'نادر نادر'], 'National_ID' => '985365785', 'Specialization_id' => 7, 'Gender_id' => 1, 'Joining_Date' => '2024-01-01', 'Address' => 'Beirut, Lebanon'],
            ['email' => 'samir1@example.com', 'name' => ['en' => 'Samir Samir', 'ar' => 'سمير سمير'], 'National_ID' => '569878524', 'Specialization_id' => 7, 'Gender_id' => 1, 'Joining_Date' => '2024-02-01', 'Address' => 'Damascus, Syria'],
            ['email' => 'rami1@example.com', 'name' => ['en' => 'Rami Rami', 'ar' => 'رامي رامي'], 'National_ID' => '889966554', 'Specialization_id' => 7, 'Gender_id' => 1, 'Joining_Date' => '2024-03-01', 'Address' => 'Baghdad, Iraq'],
            ['email' => 'nader2@example.com', 'name' => ['en' => 'Nader Hasan', 'ar' => 'نادر حسن'], 'National_ID' => '115566335', 'Specialization_id' => 8, 'Gender_id' => 1, 'Joining_Date' => '2023-12-01', 'Address' => 'Beirut, Lebanon'],
            ['email' => 'samir2@example.com', 'name' => ['en' => 'Samir Saeed', 'ar' => 'سمير سعيد'], 'National_ID' => '775566114', 'Specialization_id' => 8, 'Gender_id' => 1, 'Joining_Date' => '2024-01-01', 'Address' => 'Damascus, Syria'],
            ['email' => 'rami2@example.com', 'name' => ['en' => 'Rami Khalid', 'ar' => 'رامي خالد'], 'National_ID' => '778856428', 'Specialization_id' => 9, 'Gender_id' => 1, 'Joining_Date' => '2024-02-01', 'Address' => 'Baghdad, Iraq'],
            ['email' => 'tariq1@example.com', 'name' => ['en' => 'Tariq Tariq', 'ar' => 'طارق طارق'], 'National_ID' => '998856642', 'Specialization_id' => 10, 'Gender_id' => 1, 'Joining_Date' => '2024-03-01', 'Address' => 'Cairo, Egypt'],
            ['email' => 'kareem1@example.com', 'name' => ['en' => 'Kareem Kareem', 'ar' => 'كريم كريم'], 'National_ID' => '111552368', 'Specialization_id' => 13, 'Gender_id' => 1, 'Joining_Date' => '2024-04-01', 'Address' => 'Alexandria, Egypt'],
        ];

        foreach ($teachers as $teacher) {
            // Create user
            $user = User::create([
                'name' => $teacher['name'],
                'email' => $teacher['email'],
                'password' => Hash::make('teacher1234'),
                'role' => 'teacher',
            ]);

            // Create teacher profile
            Teacher::create([
                'user_id' => $user->id,
                'National_ID' => $teacher['National_ID'],
                'Specialization_id' => $teacher['Specialization_id'],
                'Gender_id' => $teacher['Gender_id'],
                'Joining_Date' => $teacher['Joining_Date'],
                'Address' => $teacher['Address'],
            ]);
        }
    }
}
