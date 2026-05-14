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
        Schema::table('employees', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('phone');
            $table->enum('marital_status', ['single', 'married'])->default('single')->after('birth_date');
            $table->integer('children_count')->default(0)->after('marital_status');
            $table->integer('leave_balance')->default(14)->after('children_count'); // Yıllık izin hakkı (varsayılan 14)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['birth_date', 'marital_status', 'children_count', 'leave_balance']);
        });
    }
};
