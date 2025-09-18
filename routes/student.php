<?php

use App\Http\Controllers\Student\ExamAttemptsController;
use App\Http\Controllers\Student\ExamController;
use App\Http\Controllers\Student\NotificationController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\SubjectController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::middleware(['auth', 'role:student'])->group(function () {
            Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

            Route::group(['namespace' => 'App\Http\Controllers\Student'], function () {
                Route::get('student/subjects/{id}', 'SubjectController@showSubjectContent')->name('student.subject.materials');
                Route::get('{id}/viewBook', 'SubjectController@viewBook')->name('subject.viewBook');
                Route::get('{id}/viewHomework', 'SubjectController@viewHomework')->name('subject.viewHomework');
                Route::get('{id}/view/recoreded/class', 'SubjectController@viewRecoreded')->name('subject.viewRecoreded');
                Route::get('{id}/view/zoom/class', 'SubjectController@viewZoomClass')->name('subject.viewZoomClass');
                Route::get('{id}/viewExam', 'SubjectController@viewExam')->name('subject.viewExam');
                Route::get(
                    '/subjects/{teacherSection}/scores',
                    [SubjectController::class, 'viewScores']
                )->name('student.subject.scores');


                Route::prefix('student/exams')->name('student.exam.')->group(function () {
                    Route::post('/exam/{exam_id}', [ExamController::class, 'startExam'])->name('start');
                });

                Route::prefix('student/homework-submissions')->name('student.submissions.')->group(function () {
                    Route::get('/', 'HomeworkSubmissionController@index')->name('index'); // List of assigned homeworks
                    Route::get('/{homework}/submit', 'HomeworkSubmissionController@create')->name('create'); // Submission form
                    Route::post('/{homework}', 'HomeworkSubmissionController@store')->name('store'); // Submit file
                    Route::get('/{homework}/view', 'HomeworkSubmissionController@show')->name('show'); // View submitted
                });

                Route::resource('student_exams', 'ExamController');

                Route::get('/student/exams/attempt/{attempt}/review', [ExamAttemptsController::class, 'review'])
                    ->name('student.exam.review');
            });

            Route::get('/student/exams/attempt/{attemptId}/{examId}', function ($attemptId, $examId) {
                return view('pages.Student.exams.takeExam', compact('attemptId', 'examId'));
            })->name('student.exam.take');
        });
    }


);
