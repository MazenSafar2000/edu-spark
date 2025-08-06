<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



// Route::middleware(['auth', 'role:teacher'])->group(function () {

//     Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');

// });


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::middleware(['auth', 'role:teacher'])->group(function () {

            Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');

            Route::prefix('teacher')->middleware(['auth', 'role:teacher'])->group(function () {
                Route::get('getClassroomsByGrade/{grade_id}', [AjaxController::class, 'getClassroomsByGrade']);
                Route::get('getSectionsByClassroom/{classroom_id}', [AjaxController::class, 'getSectionsByClassroom']);
                Route::get('getSubjectsBySection/{section_id}', [AjaxController::class, 'getSubjectsBySection']);
            });



            Route::group(['namespace' => 'App\Http\Controllers\Teacher'], function () {
                Route::get('/section-materials/{section_id}', 'TeacherController@showSectionMaterials')
                    ->name('teacher.section.materials');

                Route::resource('library', 'LibraryController');
                Route::get('/{section_id}/library/create', 'LibraryController@createNew')->name('createNewBook');

                Route::resource('homeworks', 'HomeworkController');
                Route::get('/{section_id}/homework/create', 'HomeworkController@createNew')->name('createNewHomework');
                Route::get('homeworks/{homework}/submissions', 'HomeworkController@showSubmissions')->name('submissions');
                Route::post('homeworks/{homework}/grade/{student}', 'HomeworkController@gradeStudent')->name('homework.grade');

                Route::resource('classes/recorded', 'RecordedClassController')->names([
                    'index' => 'recordedClasses.index',
                    'create' => 'recordedClasses.create',
                    'store' => 'recordedClasses.store',
                    'show' => 'recordedClasses.show',
                    'edit' => 'recordedClasses.edit',
                    'update' => 'recordedClasses.update',
                    'destroy' => 'recordedClasses.destroy'
                ]);
                Route::get('/{section_id}/classes/recorded/create', 'RecordedClassController@createNew')->name('createNewRecordedClass');


                Route::resource('exams', 'ExamController');
                Route::get('/{section_id}/exam/create', 'ExamController@createNew')->name('createNewExam');

                Route::resource('questions', 'QuestionController');
                Route::resource('students', 'StudentController');


                Route::get('/teacher/book/get-classrooms', 'TeacherController@getClassrooms')->name('teacher.getClassrooms');
                Route::get('/teacher/book/get-sections', 'TeacherController@getSections')->name('teacher.getSections');
                Route::get('/teacher/book/get-subjects',  'TeacherController@getSubjects')->name('teacher.getSubjects');

                Route::resource('questionsBank', 'QuestionsBankController');
                Route::resource('questionsCategotry', 'QuestionsCategotryController');
            });
        });
    }
);
