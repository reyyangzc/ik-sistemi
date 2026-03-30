<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use App\Models\SubTask;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. İbrahim Hoca (Admin) kullanıcısını oluştur
        User::factory()->create([
            'name' => 'İbrahim Hoca',
            'email' => 'admin@ik.com',
            'password' => bcrypt('123456'),
        ]);

        // 2. 10 tane personel oluştur
        User::factory(10)->create();

        // 3. 20 görev oluştur ve alt görevleri bağla
        Task::factory(20)->create()->each(function ($task) {
            SubTask::factory(rand(3, 6))->create([
                'task_id' => $task->id
            ]);
        });
    }
}