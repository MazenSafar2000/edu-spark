<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::middleware(['web', 'auth', 'role:manager'])->group(function () {
            Route::get('/ajax/classrooms/{grade}', [AjaxController::class, 'getClassrooms'])->name('ajax.classrooms');
            Route::get('/ajax/sections/{classroom}', [AjaxController::class, 'getSections'])->name('ajax.sections');
            Route::get('/ajax/subjects/{section}', [AjaxController::class, 'getSubjects'])->name('ajax.subjects');
            Route::get('/ajax/teachers/{section}/{subject}', [AjaxController::class, 'getTeachers'])->name('ajax.teachers');
            Route::get('/teachers/{teacher}/categories', [AjaxController::class, 'getCategories'])
                ->name('teachers.categories');
        });


        Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
            Route::get('getClassroomsByGrade/{grade_id}', [AjaxController::class, 'getClassroomsByGrade']);
            Route::get('getSectionsByClassroom/{classroom_id}', [AjaxController::class, 'getSectionsByClassroom']);
            Route::get('getSubjectsBySection/{section_id}', [AjaxController::class, 'getSubjectsBySection']);
        });
    }
);
