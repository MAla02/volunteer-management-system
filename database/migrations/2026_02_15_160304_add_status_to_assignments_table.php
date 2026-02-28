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
        Schema::table('assignments', function (Blueprint $table) {
            // إضافة عمود الحالة وجعل القيمة الافتراضية "قيد الانتظار"
            // نضعه بعد عمود task_id ليكون الجدول منظماً
            $table->string('status')->default('pending')->after('task_id'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            // حذف العمود في حال رغبتِ بالتراجع عن التغيير (Rollback)
            $table->dropColumn('status');
        });
    }
};