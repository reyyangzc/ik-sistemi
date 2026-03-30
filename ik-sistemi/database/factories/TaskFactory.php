<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Görevi veren kişi (Sistemdeki ilk kullanıcıyı baz alır)
            'creator_id' => User::first() ?? User::factory(),
            
            // Görevi alan kişi (Sistemdeki kullanıcılardan rastgele biri)
            'assigned_to' => User::inRandomOrder()->first() ?? User::factory(),
            
            // Gerçekçi görev başlıkları (Faker ile 4 kelimelik cümle)
            'title' => $this->faker->sentence(4),
            
            // Detaylı görev açıklaması
            'description' => $this->faker->paragraph(),
            
            // Varsayılan durum
            'status' => 'yapilacak',
            
            // Rastgele bir teslim tarihi (Bugünden itibaren 1 ile 30 gün sonrası arası)
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}