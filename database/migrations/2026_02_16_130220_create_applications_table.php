<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            
            // ربط الطلب بالمستخدم (الخريج)
            // سيفهم لارافل تلقائياً أنه مرتبط بجدول users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // ربط الطلب بالمهمة أو الفرصة التطوعية
            // سيفهم لارافل تلقائياً أنه مرتبط بجدول tasks
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            
            // حقل لتخزين مسار ملف السيرة الذاتية (CV)
            $table->string('cv_path');
            
            // حالة الطلب، والقيمة الافتراضية هي "قيد الانتظار"
            $table->string('status')->default('pending'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};