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
            
            // Görevi veren ve alan kişileri users tablosuna bağlıyoruz (İlişkisel Veritabanı)
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade');
            
            $table->string('title'); // Örn: Q3 Sunucu Bakımı
            $table->text('description')->nullable();
            
            // Görev durumları (İş akışı kuralı)
            $table->enum('status', ['yapilacak', 'devam_ediyor', 'tamamlandi'])->default('yapilacak');
            
            $table->date('due_date')->nullable(); // Son teslim tarihi
            
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