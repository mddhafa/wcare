<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/admin/dashboard', function () {
    return view('dashboard-admin');
});
// Route::middleware(['auth'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboardadmin'])->name('dashboard-admin');
// });
Route::get('/dashboard', function () {
    return view('dashboard');
}); 