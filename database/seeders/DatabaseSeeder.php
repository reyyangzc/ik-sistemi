<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Department;
use App\Models\Position;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roller (Sistem ilk kurulduğunda ID'si 1 olan Admin, 2 olan Personel olacak)
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Personel']);

        // 2. Departmanlar
        Department::create(['name' => 'Yazılım']);
        Department::create(['name' => 'İnsan Kaynakları']);
        Department::create(['name' => 'Muhasebe']);
        Department::create(['name' => 'Pazarlama']);

        // 3. Ünvanlar
        Position::create(['title' => 'Müdür']);
        Position::create(['title' => 'Kıdemli Geliştirici (Senior)']);
        Position::create(['title' => 'Uzman']);
        Position::create(['title' => 'Asistan']);
    }
}