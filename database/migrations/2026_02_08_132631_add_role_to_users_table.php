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
        // هذا الكود يضيف حقل role لجدول المستخدمين
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('volunteer')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // هذا الكود يحذف الحقل في حال أردنا التراجع
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};