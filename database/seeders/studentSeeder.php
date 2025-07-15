<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class studentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->delete();
        DB::table('users')->where('role', 'student')->delete();

        $students = [
            ['name' => ['en' => 'Ali', 'ar' => 'علي محمد'], 'email' => 'alistudent@gmail.com', 'National_ID' => '456259756' , 'gender_id' => 1, 'Date_Birth' => '2010-05-12', 'Grade_id' => 1, 'Classroom_id' => 1, 'section_id' => 1, 'parent_id' => 1, 'academic_year' => '2025/2026'],
            ['name' => ['en' => 'Sara', 'ar' => 'سارة أحمد'], 'email' => 'sarastudent@gmail.com', 'National_ID' => '885562546' , 'gender_id' => 2, 'Date_Birth' => '2011-03-08', 'Grade_id' => 1, 'Classroom_id' => 1, 'section_id' => 1, 'parent_id' => 1, 'academic_year' => '2025/2026'],
            ['name' => ['en' => 'Hassan', 'ar' => 'حسن يوسف'], 'email' => 'hassanstudent@gmail.com', 'National_ID' => '885522445' , 'gender_id' => 1, 'Date_Birth' => '2012-07-19', 'Grade_id' => 1, 'Classroom_id' => 1, 'section_id' => 1, 'parent_id' => 1, 'academic_year' => '2025/2026'],
            ['name' => ['en' => 'Lina', 'ar' => 'لينا سمير'], 'email' => 'linastudent@gmail.com', 'National_ID' => '885526558' , 'gender_id' => 2, 'Date_Birth' => '2009-11-25', 'Grade_id' => 1, 'Classroom_id' => 1, 'section_id' => 1, 'parent_id' => 4, 'academic_year' => '2025/2026'],
            ['name' => ['en' => 'Omar', 'ar' => 'عمر خالد'], 'email' => 'omarstudent@gmail.com', 'National_ID' => '789456789' , 'gender_id' => 1, 'Date_Birth' => '2013-02-14', 'Grade_id' => 1, 'Classroom_id' => 1, 'section_id' => 1, 'parent_id' => 5, 'academic_year' => '2025/2026'],
            ['name' => ['en' => 'Maya', 'ar' => 'مايا نبيل'], 'email' => 'mayastudent@gmail.com', 'National_ID' => '885522646' , 'gender_id' => 2, 'Date_Birth' => '2011-09-30', 'Grade_id' => 1, 'Classroom_id' => 1, 'section_id' => 1, 'parent_id' => 6, 'academic_year' => '2025/2026'],
            ['name' => ['en' => 'Yousef', 'ar' => 'يوسف إبراهيم'], 'email' => 'yousefstudent@gmail.com', 'National_ID' => '789534568' , 'gender_id' => 1, 'Date_Birth' => '2008-06-05', 'Grade_id' => 1, 'Classroom_id' => 1, 'section_id' => 1, 'parent_id' => 7, 'academic_year' => '2025/2026'],
            ['name' => ['en' => 'Nour', 'ar' => 'نور محمد'], 'email' => 'nourstudent@gmail.com', 'National_ID' => '789458524' , 'gender_id' => 2, 'Date_Birth' => '2010-04-22', 'Grade_id' => 1, 'Classroom_id' => 1, 'section_id' => 1, 'parent_id' => 8, 'academic_year' => '2025/2026'],
            ['name' => ['en' => 'Khaled', 'ar' => 'خالد محمود'], 'email' => 'khaledstudent@gmail.com', 'National_ID' => '759685742' , 'gender_id' => 1, 'Date_Birth' => '2012-01-17', 'Grade_id' => 1, 'Classroom_id' => 1, 'section_id' => 1, 'parent_id' => 9, 'academic_year' => '2025/2026'],
            ['name' => ['en' => 'Hana', 'ar' => 'هناء جاسم'], 'email' => 'hanastudent@gmail.com', 'National_ID' => '325655218' , 'gender_id' => 2, 'Date_Birth' => '2014-08-12', 'Grade_id' => 1, 'Classroom_id' => 1, 'section_id' => 1, 'parent_id' => 10, 'academic_year' => '2025/2026'],
        ];

        foreach ($students as $student) {
            $user = User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make('student1234'),
                'role' => 'student'
            ]);

            Student::create([
                'user_id' => $user->id,
                'National_ID' => $student['National_ID'],
                'gender_id' => $student['gender_id'],
                'Date_Birth' => $student['Date_Birth'],
                'Grade_id' => $student['Grade_id'],
                'Classroom_id' => $student['Classroom_id'],
                'section_id' => $student['section_id'],
                'parent_id' => $student['parent_id'],
                'academic_year' => $student['academic_year'],
            ]);
        }
    }
}
