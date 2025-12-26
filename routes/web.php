<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SelfHealingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EmosiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PsikologChatController;
use App\Http\Controllers\HomeChatController;
use App\Http\Middleware\Role;

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
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

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

        Route::get('/check-assigned-reports', function (Request $request) {
            $psikologId = Auth::user()->psikolog->id;
            $assignedProcessCount = \App\Models\Laporan::where('psikolog_id', $psikologId)
                ->where('status', 'proses')
                ->count();
            return response()->json(['assigned_process_count' => $assignedProcessCount]);
        })->name('api.check-assigned-reports');

        Route::get('/profile', [ProfileController::class, 'show'])->name('profilepsikolog');

        // === CHAT PSIKOLOG ===
        Route::get('/chat', [PsikologChatController::class, 'index'])->name('chat');
        Route::get('/chat/get/{user}', [PsikologChatController::class, 'showJson'])->name('chat.show');
        Route::post('/chat/send', [PsikologChatController::class, 'send'])->name('chat.send');
        Route::post('/chat/mark-read', [PsikologChatController::class, 'markAsRead'])->name('chat.markRead');
    });

    // --- KORBAN / MAHASISWA ---
    Route::middleware([Role::class . ':korban'])->group(function () {

        // Emosi & Profil
        Route::post('/pilih-emosi', [EmosiController::class, 'pilihEmosi'])->name('emosi.pilih');
        Route::get('/profile', [ProfileController::class, 'show'])->name('korban.profilekorban');

        // Chatbot AI
        Route::get('/chatbot', function () {
            return view('chatbot');
        });
        Route::post('/chat/session', [ChatbotController::class, 'newSession']);
        Route::get('/chat/sessions', [ChatbotController::class, 'sessions']);
        Route::get('/chat/messages/{id}', [ChatbotController::class, 'messages']);
        Route::post('/chat/generate', [ChatbotController::class, 'send']);

        // 1. Halaman Daftar Chat (Inbox)
        Route::get('/konsultasi', [ChatController::class, 'homechat'])->name('korban.chat.index');

        // 2. Halaman Detail Chat dengan Psikolog
        Route::get('/chat/psikolog/{id}', [ChatController::class, 'index'])->name('korban.chat.show');

        // 3. API Chat
        Route::post('/chat/send', [ChatController::class, 'send'])->name('korban.chat.send');
        Route::get('/chat/refresh/{id}', [ChatController::class, 'refresh'])->name('chat.refresh');
        Route::post('/chat/mark-read', [ChatController::class, 'markAsRead'])->name('korban.chat.markRead');
        Route::get('/chat/check', [ChatController::class, 'checkNewMessage'])->name('chat.check'); // Global check
    });

    // --- GLOBAL AUTH ROUTES ---
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
