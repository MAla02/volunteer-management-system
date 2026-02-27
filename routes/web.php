<?php

// إضافة تعديل منع الكاش
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApplicationController;

// 1. تفعيل نظام المصادقة
Auth::routes(['register' => true]);

// -------------------------------------------------------------------------
// 2. روابط الزوار (متاحة للجميع - الخريجين)
// -------------------------------------------------------------------------
Route::get('/', [ApplicationController::class, 'welcome'])->name('welcome');
Route::get('/apply/{task_id}', [ApplicationController::class, 'showApplyForm'])->name('apply.form');
// نقلنا هذا السطر هنا (خارج الـ auth) عشان الخريج الزائر يقدر يبعت طلبه
Route::post('/apply/store', [ApplicationController::class, 'store'])->name('apply.store');
Route::get('/application/status', [ApplicationController::class, 'showStatusForm'])->name('application.status.form');
Route::post('/application/status', [ApplicationController::class, 'checkStatus'])->name('application.status.check');

// -------------------------------------------------------------------------
// 3. الروابط التي تحتاج تسجيل دخول (متطوعين وأدمن)
// -------------------------------------------------------------------------
Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('my.applications');
    Route::post('/tasks-complete/{id}', [HomeController::class, 'completeTask'])->name('tasks.complete');
    Route::post('/profile/update', [HomeController::class, 'updateProfile'])->name('profile.update');

    // --- بداية روابط الأدمن فقط ---
    Route::middleware(['role:admin'])->group(function () {
        
        Route::resource('volunteers', VolunteerController::class);
        Route::resource('locations', LocationController::class);
        Route::resource('tasks', TaskController::class);
        // مسار لعرض قائمة الطلبات
        Route::get('admin/applications', [ApplicationController::class, 'index'])->name('admin.applications.index');

        // مسار لتحديث الحالة (قبول أو رفض)
        Route::patch('admin/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->name('admin.applications.updateStatus');
        
        // روابط التوزيع (Assignments)
        Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::get('assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store');
        
        Route::get('assignments/{id}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
        Route::put('assignments/{id}', [AssignmentController::class, 'update'])->name('assignments.update');
        Route::patch('/assignments/{id}/cancel', [AssignmentController::class, 'cancel'])->name('assignments.cancel');
    });
});