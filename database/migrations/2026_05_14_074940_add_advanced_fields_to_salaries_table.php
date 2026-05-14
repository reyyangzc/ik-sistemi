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
        Schema::table('salaries', function (Blueprint $table) {
            $table->decimal('bonus', 10, 2)->default(0)->after('amount');
            $table->decimal('deduction', 10, 2)->default(0)->after('bonus');
            $table->decimal('net_salary', 10, 2)->default(0)->after('deduction');
            $table->string('notes')->nullable()->after('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->dropColumn(['bonus', 'deduction', 'net_salary', 'notes']);
        });
    }
};
