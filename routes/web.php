<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SelfHealingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EmosiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\Role;
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

Route::get('/dashboard', [SelfHealingController::class, 'indexdash'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::middleware([Role::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard-admin');
        })->name('dashboard-admin');
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/mahasiswa', [AdminController::class, 'mahasiswa'])->name('mahasiswa');
        Route::get('/psikolog', [AdminController::class, 'psikolog'])->name('psikolog');

        Route::delete('/user/{id}', [AdminController::class, 'destroyUser'])->name('user.delete');
        Route::get('/user/{id}/edit', [AdminController::class, 'editUser'])->name('user.edit');
        Route::put('/user/{id}', [AdminController::class, 'updateUser'])->name('user.update');

        Route::get('/users/trash', [AdminController::class, 'trashUsers'])->name('users.trash');
        Route::post('/user/{id}/restore', [AdminController::class, 'restoreUser'])->name('user.restore');
        Route::delete('/user/{id}/force', [AdminController::class, 'forceDeleteUser'])->name('user.force_delete');

        Route::get('/tambah/selfhealing', [SelfHealingController::class, 'tambahkonten'])->name('tambahkontensh');
        Route::post('/tambah/selfhealing', [SelfHealingController::class, 'store'])->name('storekontensh');
    });

    Route::middleware([Role::class . ':psikolog'])->prefix('psikolog')->name('psikolog.')->group(function () {

        Route::get('/dashboard', [AuthController::class, 'showdashboardpsi'])
        ->name('dashboard-psikolog');
    });

    Route::middleware([Role::class.':korban'])->group(function () {
        Route::get('/chatbot', function () {
            return view('chatbot');
        });
        Route::post('/chat/generate', [ChatbotController::class, 'generate']);
        Route::post('/pilih-emosi', [EmosiController::class, 'pilihEmosi'])->name('emosi.pilih');

        Route::get('/profile', [ProfileController::class, 'index'])->name('korban.profilekorban');

        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');

        Route::get('/profile/korban/add', [ProfileController::class, 'createKorban'])->name('korban.korban-create');
        Route::post('/profile/korban/add', [ProfileController::class, 'addprofilekorban'])->name('profile.korban.store');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update.data');
    });

    Route::get('/selfhealing', [SelfHealingController::class, 'index'])->name('halamanselfhealing');

    Route::get('/lapor/arsip', [LaporanController::class, 'arsip'])->name('lapor.arsip');
    Route::get('/lapor/riwayat', [LaporanController::class, 'index'])->name('lapor.index');
    Route::get('/lapor/buat', [LaporanController::class, 'create'])->name('lapor.create');
    Route::post('/lapor', [LaporanController::class, 'store'])->name('lapor.store');
    Route::get('/lapor/{id}', [LaporanController::class, 'show'])->name('lapor.show');
    Route::put('/lapor/{id}', [LaporanController::class, 'update'])->name('lapor.update');
});
