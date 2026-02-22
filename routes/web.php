<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AssignmentController;

Route::get('/', function () {
    return redirect('/login');
});

// تفعيل Auth بدون تسجيل مستخدمين جدد
Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::resource('volunteers', VolunteerController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('tasks', TaskController::class);
    
    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store');
});
