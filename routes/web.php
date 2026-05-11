<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// 1. Herkese Açık Karşılama Sayfası
Route::get('/', function () {
    return view('welcome');
});

// 2. Giriş Yapmış Tüm Kullanıcılar (Admin + Personel)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Ortak Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil Düzenleme
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Duyurular
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

    // --- İZİN İŞLEMLERİ (TEK KONTROLCÜ: LeaveRequestController) ---
    Route::get('/leaves', [LeaveRequestController::class, 'index'])->name('leaves.index');
    Route::post('/leaves', [LeaveRequestController::class, 'store'])->name('leaves.store');
    Route::patch('/leaves/{leave}/status', [LeaveRequestController::class, 'updateStatus'])->name('leaves.status');
    Route::delete('/leaves/{leave}', [LeaveRequestController::class, 'destroy'])->name('leaves.destroy');

    // Maaş Bordroları (Görüntüleme)
    Route::get('/salaries', [SalaryController::class, 'index'])->name('salaries.index');
});

// 3. SADECE ADMİNLERİN Erişebileceği Rotalar
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Personel Yönetimi
    Route::resource('employees', EmployeeController::class);
    
    // Departman ve Pozisyon Yönetimi
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);

    // Duyuru Yönetimi (Ekleme/Silme)
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // Maaş Tanımlama
    Route::post('/salaries', [SalaryController::class, 'store'])->name('salaries.store');

    // Sistem Hareketleri (Loglar)
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});

require __DIR__.'/auth.php';