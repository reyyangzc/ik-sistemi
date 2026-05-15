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
use App\Http\Controllers\ComplaintController;
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

    // Personel Profil Güncelleme Talepleri
    Route::get('/profile-requests', [\App\Http\Controllers\ProfileChangeController::class, 'index'])->name('profile.requests.index');
    Route::post('/profile-requests', [\App\Http\Controllers\ProfileChangeController::class, 'store'])->name('profile.requests.store');

    // Duyurular
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

    // --- İZİN İŞLEMLERİ (TEK KONTROLCÜ: LeaveRequestController) ---
    Route::get('/leaves', [LeaveRequestController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [LeaveRequestController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveRequestController::class, 'store'])->name('leaves.store');
    Route::patch('/leaves/{leave}/status', [LeaveRequestController::class, 'updateStatus'])->name('leaves.status');
    Route::delete('/leaves/{leave}', [LeaveRequestController::class, 'destroy'])->name('leaves.destroy');

    // Şikayetler (Personel Ekleme)
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');

    // Maaş Bordroları (Görüntüleme ve İndirme)
    Route::get('/salaries', [SalaryController::class, 'index'])->name('salaries.index');
    Route::get('/salaries/{salary}/pdf', [SalaryController::class, 'downloadPdf'])->name('salaries.pdf');

    // Zimmetlerim (Personel Görünümü)
    Route::get('/inventories', [\App\Http\Controllers\InventoryController::class, 'index'])->name('inventories.index');

    // Masraf ve Avans Talepleri
    Route::get('/expenses', [\App\Http\Controllers\ExpenseRequestController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [\App\Http\Controllers\ExpenseRequestController::class, 'store'])->name('expenses.store');

    // İK ve Kurumsal (Performans, Eğitimler, Anketler)
    Route::get('/performance', [\App\Http\Controllers\PerformanceReviewController::class, 'index'])->name('performance.index');
    Route::get('/trainings', [\App\Http\Controllers\TrainingController::class, 'index'])->name('trainings.index');

    // Anketler
    Route::get('/surveys', [\App\Http\Controllers\SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/{survey}', [\App\Http\Controllers\SurveyController::class, 'show'])->name('surveys.show');
    Route::post('/surveys/{survey}/submit', [\App\Http\Controllers\SurveyController::class, 'submit'])->name('surveys.submit');

    // Şirket Rehberi
    Route::get('/directory', [\App\Http\Controllers\DirectoryController::class, 'index'])->name('directory.index');
});

// 3. SADECE ADMİNLERİN Erişebileceği Rotalar
Route::middleware(['auth', 'admin'])->group(function () {

    // Personel Yönetimi
    Route::resource('employees', EmployeeController::class);

    // Departman ve Pozisyon Yönetimi
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);

    // Duyuru Yönetimi (Ekleme/Düzenleme/Silme)
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // Şikayet Kutusu (Görüntüleme ve Yanıtlama)
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::patch('/complaints/{complaint}', [ComplaintController::class, 'update'])->name('complaints.update');

    // Maaş Tanımlama
    Route::post('/salaries', [SalaryController::class, 'store'])->name('salaries.store');

    // Sistem Hareketleri (Loglar)
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    // HR Modülleri Admin İşlemleri
    Route::resource('performance', \App\Http\Controllers\PerformanceReviewController::class)->except(['show', 'index']);
    Route::resource('trainings', \App\Http\Controllers\TrainingController::class)->except(['show', 'index']);

    // Profil Talepleri Onay/Red
    Route::patch('/profile-requests/{changeRequest}/approve', [\App\Http\Controllers\ProfileChangeController::class, 'approve'])->name('profile.requests.approve');
    Route::patch('/profile-requests/{changeRequest}/reject', [\App\Http\Controllers\ProfileChangeController::class, 'reject'])->name('profile.requests.reject');

    // Zimmet Yönetimi (Admin İşlemleri)
    Route::post('/inventories', [\App\Http\Controllers\InventoryController::class, 'store'])->name('inventories.store');
    Route::put('/inventories/{inventory}', [\App\Http\Controllers\InventoryController::class, 'update'])->name('inventories.update');
    Route::post('/inventories/{inventory}/assign', [\App\Http\Controllers\InventoryController::class, 'assign'])->name('inventories.assign');
    Route::post('/inventories/{inventory}/return', [\App\Http\Controllers\InventoryController::class, 'returnItem'])->name('inventories.return');

    // Masraf Talepleri Onay/Red
    Route::patch('/expenses/{expense}/approve', [\App\Http\Controllers\ExpenseRequestController::class, 'approve'])->name('expenses.approve');
    Route::patch('/expenses/{expense}/reject', [\App\Http\Controllers\ExpenseRequestController::class, 'reject'])->name('expenses.reject');

    // Anket Yönetimi (Admin)
    Route::post('/surveys', [\App\Http\Controllers\SurveyController::class, 'store'])->name('surveys.store');

    // İşe Alım ve Aday Havuzu (Admin)
    Route::get('/recruitment', [\App\Http\Controllers\RecruitmentController::class, 'index'])->name('recruitment.index');
    Route::post('/recruitment', [\App\Http\Controllers\RecruitmentController::class, 'store'])->name('recruitment.store');
    Route::get('/recruitment/{posting}/candidates', [\App\Http\Controllers\RecruitmentController::class, 'candidates'])->name('recruitment.candidates');
    Route::post('/recruitment/{posting}/candidates', [\App\Http\Controllers\RecruitmentController::class, 'addCandidate'])->name('recruitment.candidates.store');
    Route::patch('/recruitment/candidates/{candidate}/status', [\App\Http\Controllers\RecruitmentController::class, 'updateCandidateStatus'])->name('recruitment.candidates.status');
    Route::get('/veritabani-kur', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', [
        '--force' => true
    ]);

    // (Opsiyonel) Eğer seeder dosyaların varsa:
    \Illuminate\Support\Facades\Artisan::call('db:seed', [
        '--force' => true
    ]);

    return 'İşlem tamam Ci! Tablolar ve örnek veriler başarıyla oluşturuldu.';
});
});

require __DIR__.'/auth.php';
