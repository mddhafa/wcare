<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SelfHealingController;
use App\Http\Controllers\ChatbotController;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Tampilkan halaman login & register
// Route::view('/login', 'auth.login')->name('login');
// Route::view('/register', 'auth.register')->name('register');
// // Route::view('/dashboard', 'dashboard')->name('dashboard');


// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('web');

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


// Route::get('/selfhealing', [SelfHealingController::class, 'index'])->name('halamanselfhealing');
Route::middleware(['auth'])->group(function () {
    Route::get('/selfhealing', [SelfHealingController::class, 'index'])->name('halamanselfhealing');
    Route::get('/tambah/selfhealing', [SelfHealingController::class, 'tambahkonten'])->name('admin.tambahkontensh');
    Route::post('/tambah/selfhealing', [SelfHealingController::class, 'store'])->name('admin.storekontensh');

    Route::get('/chatbot', function () {
        return view('chatbot');
    });
    Route::post('/chat/generate', [ChatbotController::class, 'generate']);
});
// Route::get('/dashboard', function () {
//     return view('dashboard');
// }); 