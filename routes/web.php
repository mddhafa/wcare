<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SelfHealingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EmosiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeChatController;
use App\Http\Controllers\PsikologChatController;
use App\Http\Middleware\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/dashboard');
});

// AUTH
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// DASHBOARD UMUM
Route::get('/dashboard', [SelfHealingController::class, 'indexdash'])->name('dashboard');

// GROUP AUTH
Route::middleware(['auth'])->group(function () {

    // --- ADMIN ---
    Route::middleware([Role::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Data User
        Route::get('/mahasiswa', [AdminController::class, 'mahasiswa'])->name('mahasiswa');
        Route::get('/psikolog', [AdminController::class, 'psikolog'])->name('psikolog');
        Route::get('/psikolog/create', [AdminController::class, 'createPsikolog'])->name('psikolog.create');
        Route::post('/psikolog', [AdminController::class, 'storePsikolog'])->name('psikolog.store');

        Route::delete('/user/{id}', [AdminController::class, 'destroyUser'])->name('user.delete');
        Route::get('/user/{id}/edit', [AdminController::class, 'editUser'])->name('user.edit');
        Route::put('/user/{id}', [AdminController::class, 'updateUser'])->name('user.update');

        Route::get('/users/trash', [AdminController::class, 'trashUsers'])->name('users.trash');
        Route::post('/user/{id}/restore', [AdminController::class, 'restoreUser'])->name('user.restore');
        Route::delete('/user/{id}/force', [AdminController::class, 'forceDeleteUser'])->name('user.force_delete');

        // Konten & Laporan
        Route::get('/tambah/selfhealing', [SelfHealingController::class, 'tambahkonten'])->name('tambahkontensh');
        Route::post('/tambah/selfhealing', [SelfHealingController::class, 'store'])->name('storekontensh');
        Route::delete('/selfhealing/{id}', [SelfHealingController::class, 'destroy'])->name('deletekontensh');

        Route::post('lapor/{laporan}/assign', [LaporanController::class, 'assign'])->name('lapor.assign');
        Route::post('lapor/{laporan}/unassign', [LaporanController::class, 'unassign'])->name('lapor.unassign');
    });

    // --- PSIKOLOG ---
    Route::middleware([Role::class . ':psikolog'])->prefix('psikolog')->name('psikolog.')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showdashboardpsi'])->name('dashboard-psikolog');

        // !!! Rute BARU untuk Polling Real-time !!!
        Route::get('/check-assigned-reports', function (Request $request) {
            // Logika sederhana untuk menghitung laporan 'proses' yang ditugaskan
            $psikologId = Auth::user()->psikolog->id; // Ambil ID psikolog dari user yang login

            $assignedProcessCount = \App\Models\Laporan::where('psikolog_id', $psikologId)
                ->where('status', 'proses')
                ->count();

            return response()->json([
                'assigned_process_count' => $assignedProcessCount
            ]);
        })->name('api.check-assigned-reports'); // Nama rute yang akan dipanggil di JavaScript

        Route::get('/profile', [ProfileController::class, 'show'])->name('profilepsikolog');

        // Chat Psikolog
        Route::get('/chat', [PsikologChatController::class, 'index'])->name('chat');
        Route::get('/chat/{user}', [PsikologChatController::class, 'showJson'])->name('chat.show');
        Route::post('/chat/send', [PsikologChatController::class, 'send'])->name('chat.send');
    });

    // --- KORBAN / MAHASISWA ---
    Route::middleware([Role::class . ':korban'])->group(function () {

        // Chatbot
        Route::get('/chatbot', function () {
            return view('chatbot');
        });
        Route::post('/chat/session', [ChatbotController::class, 'newSession']);
        Route::get('/chat/sessions', [ChatbotController::class, 'sessions']);
        Route::get('/chat/messages/{id}', [ChatbotController::class, 'messages']);
        Route::post('/chat/generate', [ChatbotController::class, 'send']);

        Route::post('/pilih-emosi', [EmosiController::class, 'pilihEmosi'])->name('emosi.pilih');

        Route::get('/profile', [ProfileController::class, 'show'])->name('korban.profilekorban');

        // Chat dengan Psikolog
        Route::get('/homechat', [HomeChatController::class, 'index'])->name('homechat');
        Route::get('/chat/{id_psikolog}', [ChatController::class, 'index'])->name('chat.psikolog');
        Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
        Route::get('/chat/refresh/{id}', [ChatController::class, 'refresh'])->name('chat.refresh');
    });

    // --- GLOBAL AUTH ROUTES (Bisa diakses Psikolog & Korban) ---
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update.data');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');

    Route::get('/selfhealing', [SelfHealingController::class, 'index'])->name('halamanselfhealing');

    Route::get('/lapor/arsip', [LaporanController::class, 'arsip'])->name('lapor.arsip');
    Route::get('/lapor/riwayat', [LaporanController::class, 'index'])->name('lapor.index');
    Route::get('/lapor/buat', [LaporanController::class, 'create'])->name('lapor.create');
    Route::post('/lapor', [LaporanController::class, 'store'])->name('lapor.store');
    Route::get('/lapor/{id}', [LaporanController::class, 'show'])->name('lapor.show');
    Route::put('/lapor/{id}', [LaporanController::class, 'update'])->name('lapor.update');
});
