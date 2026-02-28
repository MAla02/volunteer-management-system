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
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        // 1. إضافة unique() لمنع تكرار اسم المهمة (مطلب أساسي في السبرنت)
        $table->string('name')->unique(); 
        
        // 2. إضافة الوصف (موجود في نسختك الكاملة)
        $table->text('description')->nullable(); 
        
        // 3. إضافة العمود المهم جداً لألاء (Category) عشان يكمل السبرنت
        $table->string('category'); 

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
