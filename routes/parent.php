<?php

use App\Http\Controllers\Parent\ParentController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/parent/dashboard', [ParentController::class, 'dashboard'])->name('parent.dashboard');
});
