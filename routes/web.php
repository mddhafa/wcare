<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SelfHealingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EmosiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
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

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/mahasiswa', [AdminController::class, 'mahasiswa'])->name('admin.mahasiswa');
    Route::get('/admin/psikolog', [AdminController::class, 'psikolog'])->name('admin.psikolog');

    Route::delete('/admin/user/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.delete');
    Route::get('/admin/user/{id}/edit', [AdminController::class, 'editUser'])->name('admin.user.edit');
    Route::put('/admin/user/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');

    Route::get('/admin/users/trash', [AdminController::class, 'trashUsers'])->name('admin.users.trash');
    Route::post('/admin/user/{id}/restore', [AdminController::class, 'restoreUser'])->name('admin.user.restore');
    Route::delete('/admin/user/{id}/force', [AdminController::class, 'forceDeleteUser'])->name('admin.user.force_delete');

    Route::get('/selfhealing', [SelfHealingController::class, 'index'])->name('halamanselfhealing');
    Route::get('/tambah/selfhealing', [SelfHealingController::class, 'tambahkonten'])->name('admin.tambahkontensh');
    Route::post('/tambah/selfhealing', [SelfHealingController::class, 'store'])->name('admin.storekontensh');

    Route::get('/chatbot', function () {
        return view('chatbot');
    });
    Route::post('/chat/generate', [ChatbotController::class, 'generate']);
    Route::post('/pilih-emosi', [EmosiController::class, 'pilihEmosi'])->name('emosi.pilih');

    Route::get('/profile', [ProfileController::class, 'index'])->name('korban.profilekorban');

    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');

    Route::get('/profile/korban/add', [ProfileController::class, 'createKorban'])->name('korban.korban-create');
    Route::post('/profile/korban/add', [ProfileController::class, 'addprofilekorban'])->name('profile.korban.store');

    Route::get('/dashboard-psikolog', function () {
        if (Auth::user()->role_id != 2 && Auth::user()->role_id != 1) {
            abort(403, 'Akses Ditolak');
        }
        return view('Psikolog.dashboard-psikolog');
    })->name('dashboard.psikolog');

    Route::get('/lapor/arsip', [LaporanController::class, 'arsip'])->name('lapor.arsip');
    Route::get('/lapor/riwayat', [LaporanController::class, 'index'])->name('lapor.index');
    Route::get('/lapor/buat', [LaporanController::class, 'create'])->name('lapor.create');
    Route::post('/lapor', [LaporanController::class, 'store'])->name('lapor.store');
    Route::get('/lapor/{id}', [LaporanController::class, 'show'])->name('lapor.show');
    Route::put('/lapor/{id}', [LaporanController::class, 'update'])->name('lapor.update');

    Route::get('/profile', [ProfileController::class, 'index'])->name('korban.profilekorban');
    
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update.data');
});
