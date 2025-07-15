<?php

namespace Database\Seeders;

use App\Models\ParentProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class parentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parents')->delete();
        DB::table('users')->where('role', 'parent')->delete();

        $parents = [
            ['email' => 'emadfather@gmail.com', 'name' =>['en' => 'Emad', 'ar' => 'عماد محمد'], 'National_ID' => '778855224' , 'phone' => '1234567810', 'job_en' => 'Programmer', 'job_ar' => 'مبرمج', 'address' => 'غزة، الرمال'],
            ['email' => 'ahmedfather@gmail.com', 'name' =>['en' => 'Ahmed', 'ar' => 'أحمد علي'], 'National_ID' => '996655887' , 'phone' => '1234567820', 'job_en' => 'Engineer', 'job_ar' => 'مهندس', 'address' => 'غزة، الشجاعية'],
            ['email' => 'khaledfather@gmail.com', 'name' =>['en' => 'Khaled', 'ar' => 'خالد حسن'], 'National_ID' => '789456125' , 'phone' => '1234567830', 'job_en' => 'Doctor', 'job_ar' => 'طبيب', 'address' => 'غزة، الزيتون'],
            ['email' => 'mohamedfather@gmail.com', 'name' =>['en' => 'Mohamed', 'ar' => 'محمد سمير'], 'National_ID' => '998853664' , 'phone' => '1234567840', 'job_en' => 'Teacher', 'job_ar' => 'مدرس', 'address' => 'غزة، التفاح'],
            ['email' => 'omarfather@gmail.com', 'name' =>['en' => 'Omar', 'ar' => 'عمر سعيد'], 'National_ID' => '885522648' , 'phone' => '1234567850', 'job_en' => 'Lawyer', 'job_ar' => 'محامي', 'address' => 'غزة، الجلاء'],
            ['email' => 'hassanfather@gmail.com', 'name' =>['en' => 'Hassan', 'ar' => 'حسن مصطفى'], 'National_ID' => '812385648' , 'phone' => '1234567860', 'job_en' => 'Accountant', 'job_ar' => 'محاسب', 'address' => 'غزة، النصر'],
            ['email' => 'youseffather@gmail.com', 'name' =>['en' => 'Yousef', 'ar' => 'يوسف إبراهيم'], 'National_ID' => '778877887' , 'phone' => '1234567870', 'job_en' => 'Architect', 'job_ar' => 'مهندس معماري', 'address' => 'غزة، الشيخ رضوان'],
            ['email' => 'mahmoudfather@gmail.com', 'name' =>['en' => 'Mahmoud', 'ar' => 'محمود صالح'], 'National_ID' => '998899858' , 'phone' => '1234567880', 'job_en' => 'Designer', 'job_ar' => 'مصمم', 'address' => 'غزة، الجندي المجهول'],
            ['email' => 'tariqfather@gmail.com', 'name' =>['en' => 'Tariq', 'ar' => 'طارق زيدان'], 'National_ID' => '993355229' , 'phone' => '1234567890', 'job_en' => 'Manager', 'job_ar' => 'مدير', 'address' => 'غزة، دوار أنصار'],
            ['email' => 'walidfather@gmail.com', 'name' =>['en' => 'Walid', 'ar' => 'وليد حسن'], 'National_ID' => '221122145' , 'phone' => '1234567800', 'job_en' => 'Analyst', 'job_ar' => 'محلل', 'address' => 'غزة، السرايا'],
            ['email' => 'saadfather@gmail.com', 'name' =>['en' => 'Saad', 'ar' => 'سعد محمود'], 'National_ID' => '552255225' , 'phone' => '1234567901', 'job_en' => 'Electrician', 'job_ar' => 'كهربائي', 'address' => 'غزة، الشيخ عجلين'],
            ['email' => 'ramzifather@gmail.com', 'name' =>['en' => 'Ramzi', 'ar' => 'رمزي حسن'], 'National_ID' => '785236547' , 'phone' => '1234567902', 'job_en' => 'Technician', 'job_ar' => 'فني', 'address' => 'غزة، تل الهوى'],
            ['email' => 'fadyfather@gmail.com', 'name' =>['en' => 'Fady', 'ar' => 'فادي سمير'], 'National_ID' => '753575357' , 'phone' => '1234567903', 'job_en' => 'Plumber', 'job_ar' => 'سباك', 'address' => 'غزة، شارع الوحدة'],
            ['email' => 'samirfather@gmail.com', 'name' =>['en' => 'Samir', 'ar' => 'سمير عدنان'], 'National_ID' => '951595159' , 'phone' => '1234567904', 'job_en' => 'Mechanic', 'job_ar' => 'ميكانيكي', 'address' => 'غزة، السوق الشعبي'],
            ['email' => 'hishamfather@gmail.com', 'name' =>['en' => 'Hisham', 'ar' => 'هشام يوسف'], 'National_ID' => '559986855' , 'phone' => '1234567905', 'job_en' => 'Carpenter', 'job_ar' => 'نجار', 'address' => 'غزة، شارع الثلاثيني'],
            ['email' => 'nassirfather@gmail.com', 'name' =>['en' => 'Nassir', 'ar' => 'ناصر جمال'], 'National_ID' => '128787125' , 'phone' => '1234567906', 'job_en' => 'Driver', 'job_ar' => 'سائق', 'address' => 'غزة، الزيتون'],
            ['email' => 'bilalfather@gmail.com', 'name' =>['en' => 'Bilal', 'ar' => 'بلال علي'], 'National_ID' => '983289325' , 'phone' => '1234567907', 'job_en' => 'Photographer', 'job_ar' => 'مصور', 'address' => 'غزة، الرمال'],
            ['email' => 'jamalfather@gmail.com', 'name' =>['en' => 'Jamal', 'ar' => 'جمال خالد'], 'National_ID' => '785412587' , 'phone' => '1234567908', 'job_en' => 'Painter', 'job_ar' => 'رسام', 'address' => 'غزة، الجلاء'],
            ['email' => 'rashidfather@gmail.com', 'name' =>['en' => 'Rashid', 'ar' => 'راشد سمير'], 'National_ID' => '741852147' , 'phone' => '1234567909', 'job_en' => 'Cook', 'job_ar' => 'طباخ', 'address' => 'غزة، الشيخ رضوان'],
            ['email' => 'aymanfather@gmail.com', 'name' =>['en' => 'Ayman', 'ar' => 'أيمن زكريا'], 'National_ID' => '856987458' , 'phone' => '1234567910', 'job_en' => 'Security Guard', 'job_ar' => 'حارس أمن', 'address' => 'غزة، السرايا'],
            ['email' => 'kamalfather@gmail.com', 'name' =>['en' => 'Kamal', 'ar' => 'كمال زهير'], 'National_ID' => '987456987' , 'phone' => '1234567911', 'job_en' => 'Dentist', 'job_ar' => 'طبيب أسنان', 'address' => 'غزة، الرمال'],
            ['email' => 'bahaa_father@gmail.com', 'name' =>['en' => 'Bahaa', 'ar' => 'بهاء يوسف'], 'National_ID' => '998855364' , 'phone' => '1234567912', 'job_en' => 'Chef', 'job_ar' => 'طاه', 'address' => 'غزة، الشيخ عجلين'],
            ['email' => 'nizarfather@gmail.com', 'name' =>['en' => 'Nizar', 'ar' => 'نزار حسام'], 'National_ID' => '789456854' , 'phone' => '1234567913', 'job_en' => 'Veterinarian', 'job_ar' => 'طبيب بيطري', 'address' => 'غزة، شارع الوحدة'],
            ['email' => 'tareqfather@gmail.com', 'name' =>['en' => 'Tareq', 'ar' => 'طارق سمير'], 'National_ID' => '888555265' , 'phone' => '1234567914', 'job_en' => 'IT Specialist', 'job_ar' => 'اخصائي تقنية معلومات', 'address' => 'غزة، السرايا'],
            ['email' => 'muhannadfather@gmail.com', 'name' =>['en' => 'Muhannad', 'ar' => 'مهند خالد'], 'National_ID' => '987444456' , 'phone' => '1234567915', 'job_en' => 'Electrician', 'job_ar' => 'كهربائي', 'address' => 'غزة، التفاح'],
            ['email' => 'ibrahimfather@gmail.com', 'name' =>['en' => 'Ibrahim', 'ar' => 'إبراهيم محمود'], 'National_ID' => '253556645' , 'phone' => '1234567916', 'job_en' => 'Librarian', 'job_ar' => 'أمين مكتبة', 'address' => 'غزة، الجلاء'],
            ['email' => 'zaki_father@gmail.com', 'name' =>['en' => 'Zaki', 'ar' => 'زكي وليد'], 'National_ID' => '885522645' , 'phone' => '1234567917', 'job_en' => 'Journalist', 'job_ar' => 'صحفي', 'address' => 'غزة، الشيخ رضوان'],
            ['email' => 'raedfather@gmail.com', 'name' =>['en' => 'Raed', 'ar' => 'رائد سمير'], 'National_ID' => '885522654' , 'phone' => '1234567918', 'job_en' => 'Civil Engineer', 'job_ar' => 'مهندس مدني', 'address' => 'غزة، دوار أنصار'],
            ['email' => 'samirfather2@gmail.com', 'name' =>['en' => 'Samir', 'ar' => 'سمير عادل'], 'National_ID' => '778855665' , 'phone' => '1234567919', 'job_en' => 'Banker', 'job_ar' => 'موظف بنك', 'address' => 'غزة، الجندي المجهول'],
            ['email' => 'faresfather@gmail.com', 'name' =>['en' => 'Fares', 'ar' => 'فارس زكريا'], 'National_ID' => '995533586' , 'phone' => '1234567920', 'job_en' => 'Pharmacist', 'job_ar' => 'صيدلي', 'address' => 'غزة، تل الهوى'],
        ];

        foreach ($parents as $parent) {
            // Create user
            $user = User::create([
                'name' => $parent['name'],
                'email' => $parent['email'],
                'password' => Hash::make('parent1234'),
                'role' => 'parent',
            ]);

            // Create parent profile
            ParentProfile::create([
                'user_id' => $user->id,
                'National_ID' => $parent['National_ID'],
                'Phone_Father' => $parent['phone'],
                'Job_Father' => (['en' => $parent['job_en'], 'ar' => $parent['job_ar']]),
                'Address_Father' => $parent['address'],
            ]);
        }
    }
}
