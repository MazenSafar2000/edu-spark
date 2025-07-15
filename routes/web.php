<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Parent\ParentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Manager\StudentController as MangerStudentController;
use App\Http\Controllers\Manager\TeacherController as ManagerTeacherController;
use App\Http\Controllers\Teacher\TeacherController;
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
        Route::get('/', [HomeController::class, 'index'])->name('loginpage');
        Route::get('aboutUs', [HomeController::class, 'about'])->name('aboutUs');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        Route::get('/login-student-parent', [CustomLoginController::class, 'showStudentParentLogin'])->name('login.student_parent');
        Route::get('/school', [CustomLoginController::class, 'showTeacherManagerLogin'])->name('login.teacher_manager');


        Route::middleware(['auth', 'role:manager'])->group(function () {
            Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');

            Route::get('/Get_classrooms/{id}', [AjaxController::class, 'getClassrooms']);
            Route::get('/Get_Sections/{id}', [AjaxController::class, 'Get_Sections']);

            Route::group(['namespace' => 'App\Http\Controllers\Manager'], function () {
                Route::resource('Students', 'StudentController');
                Route::get('Download_attachment/{studentsname}/{filename}', 'ImageController@Download_attachment')->name('Download_attachment');

                Route::resource('Teachers', 'TeacherController');
                Route::get('Teachers/Classes/{id}', 'TeacherController@TeacherClasses')->name('TeachersClasses');
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


                // Route::resource('online_classes', 'OnlineClasseController');
                // Route::get('indirect_admin', 'OnlineClasseController@indirectCreate')->name('indirect.create.admin');
                // Route::post('indirect_admin', 'OnlineClasseController@storeIndirect')->name('indirect.store.admin');
                // Route::resource('Graduated', 'GraduatedController');
                // Route::post('/Graduated/one', 'GraduatedController@graduateOne')->name('Graduated.one');
                // Route::resource('Promotion', 'PromotionController');
                // Route::get('download_file/{filename}', 'LibraryController@downloadAttachment')->name('downloadAttachment');
                // Route::resource('library', 'LibraryController');
                // Route::post('Upload_attachment', 'StudentController@Upload_attachment')->name('Upload_attachment');
                // Route::get('Download_attachment/{studentsname}/{filename}', 'StudentController@Download_attachment')->name('Download_attachment');
                // Route::post('Delete_attachment', 'StudentController@Delete_attachment')->name('Delete_attachment');
            });

            Route::view('add_parent', 'livewire.add-parent')->name('add_parent');
        });
    }
);



require __DIR__ . '/auth.php';
