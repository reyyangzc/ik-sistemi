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
        Schema::create('sub_tasks', function (Blueprint $table) {
            $table->id();
            
            // Hangi ana göreve ait olduğunu belirliyoruz
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            
            $table->string('title'); // Örn: Logların temizlenmesi
            $table->enum('status', ['yapilacak', 'tamamlandi'])->default('yapilacak');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_tasks');
    }
};