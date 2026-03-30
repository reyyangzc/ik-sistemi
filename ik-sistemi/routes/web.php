<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// 1. Giriş Yönlendirmesi
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Güvenli Bölge
Route::middleware(['auth', 'verified'])->group(function () {
    // Burada nokta (.) yerine çift iki nokta (::) kullandık
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
    Route::post('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::post('/tasks/{id}/comments', [TaskController::class, 'storeComment'])->name('tasks.comments.store');
});

// 3. RAK GLOBAL - 40 DOSYALIK DEV OPERASYON
Route::get('/turkce-yap', function () {
    Task::query()->delete();
    
    $admin = User::where('email', 'admin@ik.com')->first();
    
    $mehmet = User::updateOrCreate(
        ['email' => 'mehmet@ik.com'],
        ['name' => 'Mehmet Soykan', 'password' => Hash::make('123456')]
    );
    
    $clara = User::firstOrCreate(
        ['email' => 'clara@rak.com'],
        ['name' => 'Clara Von Hohenzollern', 'password' => Hash::make('123456')]
    );
    
    $james = User::firstOrCreate(
        ['email' => 'james@rak.com'],
        ['name' => 'James W. Sterling', 'password' => Hash::make('123456')]
    );

    $yoneticiler = [$admin, $mehmet, $clara, $james];
    $durumlar = ['yapilacak', 'devam_ediyor', 'tamamlandi'];
    
    $stratejikBasliklar = [
        'Kuzey Avrupa Pazar Analizi', 'Yapay Zeka Etik Protokolü', 'Likidite Risk Projeksiyonu',
        'Blockchain Entegrasyon Analizi', 'Sürdürülebilirlik Endeksi', 'Global Lojistik Optimizasyonu',
        'Siber Güvenlik Katmanı', 'Yetenek Havuzu Akreditasyonu', 'Dış Ticaret Dengesi Raporu',
        'Kurumsal Hafıza Restorasyonu', 'Enerji Verimliliği Master Planı', 'Kriz Yönetim Algoritması'
    ];

    for ($i = 1; $i <= 40; $i++) {
        $yonetici = $yoneticiler[array_rand($yoneticiler)];
        $baslik = $stratejikBasliklar[array_rand($stratejikBasliklar)] . " - Faz " . rand(1, 9);
        
        $t = Task::create([
            'title' => $baslik,
            'description' => "RAK Global Stratejik Hedefleri doğrultusunda, $i numaralı protokol çerçevesinde yürütülen operasyonel süreç yönetimidir. Kurumsal disiplin ve tam akreditasyon esastır.",
            'assigned_to' => $yonetici->id,
            'creator_id' => $admin->id,
            'status' => $durumlar[array_rand($durumlar)]
        ]);

        SubTask::create(['task_id' => $t->id, 'title' => 'Veri Analitiği Kontrolü', 'status' => 'tamamlandi']);
        SubTask::create(['task_id' => $t->id, 'title' => 'Risk Yönetim Onayı', 'status' => 'yapilacak']);
    }

    return "RAK GLOBAL SİSTEMİ MÜHÜRLENDİ! Dashboard'a dönebilirsiniz.";
});

require __DIR__.'/auth.php';