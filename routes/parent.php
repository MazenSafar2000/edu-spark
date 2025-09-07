<?php

use App\Http\Controllers\Parent\ParentController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::middleware(['auth', 'role:parent'])->group(function () {
            Route::get('/parent/dashboard', [ParentController::class, 'dashboard'])->name('parent.dashboard');

            Route::group(['namespace' => 'App\Http\Controllers\Parent'], function () {
                Route::get('parent/profile', [ParentController::class, 'profile'])->name('parent.profile');
                Route::get('parent/student/subjects/{studentId}', [ParentController::class, 'studentSubjects'])->name('student.subjects');
                Route::get('/materials/{subjectId}/{studentId}', [ParentController::class, 'subjectsMaterials'])->name('subject.materials');
                Route::get('/materials/book/{bookId}/{studentId}', [ParentController::class, 'bookDetails'])->name('book.details');
                Route::get('/materials/exam/{examId}/{studentId}', [ParentController::class, 'examDetails'])->name('exam.details');
                Route::get('/materials/homework/{homeworkId}/{studentId}', [ParentController::class, 'homeworkDetails'])->name('homework.details');
                Route::get('/materials/recordedClass/{classId}//{studentId}', [ParentController::class, 'recordedClassDetails'])->name('recordedClass.details');
                Route::get('/materials/zoom/{classId}//{studentId}', [ParentController::class, 'zoomClassDetails'])->name('zoomClass.details');
            });
        });
    }
);
