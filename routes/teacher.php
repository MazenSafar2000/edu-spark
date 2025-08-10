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
                Route::get('{exam_id}/exam/questions/index', 'ExamController@addQuestions')->name('addQuestions');
                Route::resource('sectionsExams', 'SectionExamContrller');
                // Route::post('/teacher/exams/assign', 'TeacherExamController@assign')->name('teacher.exams.assign');


                Route::resource('questions', 'QuestionController');
                Route::resource('examQuestions', 'ExamQuestionsController');
                Route::get('/exams/{exam}/questions', 'ExamQuestionsController@index')->name('examQuestions.index');
                // Get questions by category (used in modal - AJAX)
                Route::get('/exam/questions-by-category/{category_id}', 'ExamQuestionsController@getQuestionsByCategory')->name('exam.questions.byCategory');

                // Store selected questions from bank
                Route::post('/exam/add-from-bank/{exam}', 'ExamQuestionsController@storeFromBank')->name('exam.questions.storeFromBank');

                // Store random questions
                Route::post('/exam/add-random/{exam}', 'ExamQuestionsController@storeRandomQuestions')->name('exam.questions.storeRandom');

                // delete questions
                Route::delete('/exam/{exam}/question/{question}', 'ExamQuestionsController@removeQuestionFromExam')->name('exam.remove-question');

                //update maximum grade & shuffle questions
                Route::put('/exams/{exam}/questions/settings', 'ExamQuestionsController@updateSettings')
                    ->name('exam.questions.updateSettings');






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
