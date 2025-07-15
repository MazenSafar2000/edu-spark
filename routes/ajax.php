<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'role:manager'])->group(function () {
    // Route::get('/Get_classrooms/{id}', [AjaxController::class, 'getClassrooms']);
    // Route::get('/Get_Sections/{id}', [AjaxController::class, 'Get_Sections']);
});


// Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
//     Route::get('getClassroomsByGrade/{grade_id}', [AjaxController::class, 'getClassroomsByGrade']);
//     Route::get('getSectionsByClassroom/{classroom_id}', [AjaxController::class, 'getSectionsByClassroom']);
//     Route::get('getSubjectsBySection/{section_id}', [AjaxController::class, 'getSubjectsBySection']);
// });
