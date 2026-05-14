<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roller (Sistem ilk kurulduğunda ID'si 1 olan Admin, 2 olan Personel olacak)
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Personel']);

        // 2. Departmanlar (En az 6-7 farklı departman)
        $depts = [
            'Yazılım' => ['Müdür', 'Kıdemli Geliştirici (Senior)', 'Geliştirici (Mid)', 'Yazılım Destek Uzmanı'],
            'İnsan Kaynakları' => ['İK Müdürü', 'İşe Alım Uzmanı', 'Bordro Uzmanı', 'Asistan'],
            'Pazarlama' => ['Pazarlama Müdürü', 'Dijital Pazarlama Uzmanı', 'İçerik Üreticisi', 'Grafiker'],
            'Finans' => ['Finans Müdürü', 'Muhasebe Uzmanı', 'Mali Müşavir', 'Finansal Analist'],
            'Satış' => ['Satış Müdürü', 'Bölge Sorumlusu', 'Satış Temsilcisi', 'Müşteri Temsilcisi'],
            'Ar-Ge' => ['Ar-Ge Müdürü', 'Araştırmacı', 'Ürün Geliştirme Uzmanı', 'Veri Analisti'],
        ];

        foreach ($depts as $deptName => $positions) {
            $department = Department::create(['name' => $deptName]);
            foreach ($positions as $posName) {
                Position::create([
                    'name' => $posName,
                    'department_id' => $department->id
                ]);
            }
        }

        // 3. Admin Kullanıcısı Oluşturma
        User::create([
            'name' => 'Sistem Yöneticisi',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role_id' => 1 // Admin yetkisi
        ]);
    }
}