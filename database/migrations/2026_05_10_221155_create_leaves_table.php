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
       Schema::create('leaves', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained()->onDelete('cascade'); // Personel silinirse izinleri de silinsin [cite: 48]
    $table->foreignId('leave_type_id')->constrained();
    $table->date('start_date');
    $table->date('end_date');
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Admin onayı için [cite: 67]
    $table->text('reason')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
