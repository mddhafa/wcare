<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SelfHealingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EmosiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/me', [AuthController::class, 'me'])->name('me');
Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');

Route::get('/admin/dashboard', function () {
    return view('dashboard-admin');
});

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

    Route::get('/dashboard-psikolog', function () {
        if (Auth::user()->role_id != 2 && Auth::user()->role_id != 1) {
            abort(403, 'Akses Ditolak');
        }
        return view('Psikolog.dashboard-psikolog');
    })->name('dashboard.psikolog');

    Route::get('/lapor/riwayat', [LaporanController::class, 'index'])->name('lapor.index');
    Route::get('/lapor/buat', [LaporanController::class, 'create'])->name('lapor.create');
    Route::post('/lapor', [LaporanController::class, 'store'])->name('lapor.store');
    Route::get('/lapor/{id}', [LaporanController::class, 'show'])->name('lapor.show');
    Route::put('/lapor/{id}', [LaporanController::class, 'update'])->name('lapor.update');
});
