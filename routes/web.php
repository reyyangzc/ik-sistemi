<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SalaryController;
use Illuminate\Support\Facades\Route;

// 1. Herkese Açık Karşılama Sayfası
Route::get('/', function () {
    return view('welcome');
});

// 2. Giriş Yapmış Tüm Kullanıcılar (Admin + Personel)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Ortak Dashboard
   // Dashboard'u Controller üzerinden çağırıyoruz (MVC Şartı)
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    // Profil Düzenleme
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // İzin İşlemleri (Ortak Görüntüleme ve Talep Oluşturma)
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');

    // Maaş Bordroları (Ortak Görüntüleme)
    Route::get('/salaries', [SalaryController::class, 'index'])->name('salaries.index');
});

// 3. SADECE ADMİNLERİN (Yöneticilerin) Erişebileceği Rotalar (Güvenlik Madde 9 & 62)
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Personel Yönetimi (Ekle/Sil/Güncelle - CRUD Madde 8)
    Route::resource('employees', EmployeeController::class);
    
    // Departman ve Pozisyon Yönetimi (12 Tablo şartı için)
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);

    // İzin Onaylama Mekanizması (Admin'e özel güncelleme - Madde 65)
    Route::patch('/leaves/{leave}/status', [LeaveController::class, 'updateStatus'])->name('leaves.updateStatus');

    // Maaş Tanımlama (Sadece Admin yeni maaş girişi yapabilir)
    Route::post('/salaries', [SalaryController::class, 'store'])->name('salaries.store');

    // Sistem Hareketleri (İşlem Logları - Madde 68)
    // Sadece adminlerin kimin ne yaptığını görmesi için buraya aldık
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});

require __DIR__.'/auth.php';