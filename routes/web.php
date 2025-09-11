<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\manager\PromotionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        // Post routes for handling login submission
        Route::post('/login-student', [CustomLoginController::class, 'loginStudent'])->name('login.student');
        Route::post('/login-parent', [CustomLoginController::class, 'loginParent'])->name('login.parent');
        Route::post('/login-teacher', [CustomLoginController::class, 'loginTeacher'])->name('login.teacher');
        Route::post('/login-manager', [CustomLoginController::class, 'loginManager'])->name('login.manager');
        // Route::get('/', [HomeController::class, 'index'])->name('loginpage');
        Route::get('/', [HomeController::class, 'landingPage'])->name('landingPage');
        // Route::get('aboutUs', [HomeController::class, 'about'])->name('aboutUs');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        Route::get('/login/student&parent', [CustomLoginController::class, 'showStudentParentLogin'])->name('login.student_parent');
        Route::get('/school', [CustomLoginController::class, 'showTeacherManagerLogin'])->name('login.teacher_manager');


        Route::middleware(['auth', 'role:manager'])->group(function () {
            Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');

            Route::group(['namespace' => 'App\Http\Controllers\Manager'], function () {

                Route::resource('Students', 'StudentController');
                Route::get('Download_attachment/{studentsname}/{filename}', 'ImageController@Download_attachment')->name('Download_attachment');

                Route::resource('Teachers', 'TeacherController');
                Route::get('Teachers/Classes/{id}', 'TeacherController@TeacherClasses')->name('TeachersClasses');
                Route::get('/section-materials/{teacherId}/{sectionId}', 'TeacherController@showSectionMaterials')
                    ->name('teacher.section.data');
                Route::resource('Grades', 'GradeController');
                Route::resource('Classrooms', 'ClassroomController');
                Route::resource('Parents', 'ParentController');
                Route::resource('Sections', 'SectionController');
                Route::get('Grades/Sections/Teachers/{id}', 'SectionController@TeachersSection')->name('teachersSection');
                Route::get('Grades/Sections/Students/{id}', 'SectionController@StudentsSection')->name('studentsSection');
                Route::resource('Specializations', 'SpecializationController');
                Route::resource('Subjects', 'SubjectController');
                Route::resource('TeacherSections', 'TeacherSectionController');

                Route::resource('Images', 'ImageController');

                Route::resource('Promotion', 'PromotionController');

                Route::resource('Graduate', 'GraduatedController');
                Route::post('/Graduated/one/{studentId}', 'GraduatedController@graduateOne')->name('Graduated.one');
                Route::post('/promotions/rollback-selected', [PromotionController::class, 'rollbackSelected'])
                    ->name('Promotion.rollbackSelected');
            });

            // Route::view('add_parent', 'livewire.add-parent')->name('add_parent');

        });

        Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])
            ->middleware('auth')
            ->name('notifications.readAll');
    }
);

require __DIR__ . '/auth.php';
