<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CorporateStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    // Departmanlar
    $depts = [
        ['name' => 'İnsan Kaynakları'],
        ['name' => 'Siber Güvenlik'],
        ['name' => 'Donanım Tasarımı'],
        ['name' => 'Güvenlik'],
        ['name' => 'Mühendislik ve Ar-Ge'],
        ['name' => 'İdari İşler'],
        ['name' => 'Teknik Destek'],
        ['name' => 'Hukuk'],
        ['name' => 'Pazarlama'],
        ['name' => 'Lojistik'],
        ['name' => 'Muhasebe'],
        ['name' => 'Finans ve Operasyon']
    ];
    foreach($depts as $d) {
        \App\Models\Department::firstOrCreate($d);
    }

    // Ünvanlar
    $positions = [
        ['name' => 'Kıdemli Yazılım Mühendisi'],
        ['name' => 'Güvenlik Analisti'],
        ['name' => 'Gömülü Sistem Uzmanı'],
        ['name' => 'Müdür'],
        ['name' => 'Genel Müdür'],
        ['name' => 'Teknisyen'],
        ['name' => 'CEO'],
        ['name' => 'Proje Yöneticisi'],
        ['name' => 'Mühendislik ve Ar-Ge'],
        ['name' => 'Mühendislik ve Ar-Ge'],
        ['name' => 'Mühendislik ve Ar-Ge']
    ];
    foreach($positions as $p) {
        \App\Models\Position::firstOrCreate($p);
    }
}
}
