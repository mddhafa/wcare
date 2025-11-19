<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SelfHealingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EmosiController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
Route::post('/me', [AuthController::class, 'me'])->name('me');

Route::get('/admin/dashboard', function () {
    return view('dashboard-admin');
});
// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboardadmin'])->name('dashboard-admin');
// });


    Route::get('/dashboard', [SelfHealingController::class, 'indexdash'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/selfhealing', [SelfHealingController::class, 'index'])->name('halamanselfhealing');
    Route::get('/tambah/selfhealing', [SelfHealingController::class, 'tambahkonten'])->name('admin.tambahkontensh');
    Route::post('/tambah/selfhealing', [SelfHealingController::class, 'store'])->name('admin.storekontensh');

    Route::get('/chatbot', function () {
        return view('chatbot');
    });
    Route::post('/chat/generate', [ChatbotController::class, 'generate']);

    Route::post('/pilih-emosi', [EmosiController::class, 'pilihEmosi'])->name('emosi.pilih');

    Route::get('/profile', [ProfileController::class, 'index'])->name('korban.profilekorban');

    Route::get('/profile/korban/add', [ProfileController::class, 'createKorban'])->name('korban.korban-create');

    Route::post('/profile/korban/add', [ProfileController::class, 'addprofilekorban'])->name('profile.korban.store');

});
 