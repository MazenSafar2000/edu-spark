<?php

use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

});
