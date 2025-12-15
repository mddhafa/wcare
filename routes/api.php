<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/refresh', [AuthController::class, 'refresh']);
// Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Route::get('/register', [\App\Http\Controllers\Api\AuthController::class, 'showregister']);
// Route::get('/login', [\App\Http\Controllers\Api\AuthController::class, 'showlogin']);
// routes/api.php

Route::get('/check-new-reports', function () {
    // 1. Ambil jumlah laporan yang statusnya 'pending'
    $pendingCount = \App\Models\Laporan::where('status', 'pending')->count();

    // 2. Kembalikan sebagai JSON
    return response()->json([
        'pending_count' => $pendingCount
    ]);
})->name('api.check-new-reports');
