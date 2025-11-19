<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;
use App\Models\Admin;
use App\Models\Psikolog;
use App\Models\Korban;
// <<<<<<< HEAD
use Illuminate\Support\Facades\Log;


// class AuthController extends Controller
// {
// public function register(RegisterRequest $request)
// {
//     try {
// =======

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try{
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();

        return response()->json([
                // 'status_code' => 201,
                'message' => 'Berhasil melakukan registrasi',
                'data'    => $user,

            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Gagal melakukan registrasi',
                'error'   => $e->getMessage(),
            ], 500);
        }

    //     $user = User::create([
    //     'name' => $request->name,
    //     'email' => $request->email,
    //     'password' => bcrypt($request->password),
    //     'role_id' => $request->role_id,
    // ]);

    // Cek role dan buat data sesuai tabel relasinya
//     if ($request->role_id == 1) { 
//         // Admin
//         $user->admin()->create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => bcrypt($request->password),
//         ]);
//     } 
//     elseif ($request->role_id == 2) { 
//         // Psikolog
//         $user->psikolog()->create([
//             'name' => $request->name,
//             // 'license_number' => $request->license_number ?? null, // contoh field tambahan
//             // 'specialization' => $request->specialization ?? null,
//             'email' => $request->email,
//             'password' => bcrypt($request->password),
//             // 'jadwal_tersedia' => $request->jadwal_tersedia ?? 'Belum ditentukan',
//         ]);
//     } 
//     elseif ($request->role_id == 3) { 
//         // Korban
//         $user->korban()->create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => bcrypt($request->password),
//             'umur' => $request->umur ?? null,
//             'jenis_kelamin' => $request->jenis_kelamin ?? null,
//             // 'phone' => $request->phone ?? null,
//         ]);
//     }

//     return response()->json([
//         'message' => 'User registered successfully',
//         'user' => $user
//     ], 201);
// }

    }

    public function showregister()
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::guard('web')->user();

            // Jika AJAX (fetch)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Login berhasil',
                    'data' => [
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role->name ?? $user->role, // admin / korban
                    ]
                ]);
            }

            // Login biasa
            if (($user->role->name ?? $user->role) === 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/dashboard');
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function showlogin()
    {
        return view('auth.login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function dashoardadmin()
    {
        return view('dashboard-admin');
    }

    public function me()
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan',
                // 'status_code' => 404,
                'data' => null
            ], 404);
        }

        $formatedUser = [
            'user_id' => $user->user_id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role->name,
        ];

        return response()->json([
            'message' => 'User ditemukan',
            // 'status_code' => 200,
            'data' => $formatedUser
        ], 200);
    }

    public function refresh()
    {
        try {
            $newToken = Auth::guard('web')->refresh();

            return response()->json([
                'message' => 'Token refreshed successfully',
                // 'status_code' => 200,
                'data' => ['token' => $newToken]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Could not refresh token: ' . $e->getMessage(),
                // 'status_code' => 500,
                'data' => null
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        // Auth::guard('web')->logout();

        // return response()->json([
        //     'message' => 'Logout berhasil',
        //     // 'status_code' => 200,
        //     'data' => null
        // ], 200);

    Auth::guard('web')->logout();

    // Logout dari guard web (supaya Blade @auth jadi guest lagi)
    Auth::guard('web')->logout();

    // Hapus session
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('message', 'Berhasil logout');
    }

//     public function logout(Request $request)
// {
//     Auth::guard('web')->logout();
//     Auth::guard('web')->logout();

//     $request->session()->invalidate();
//     $request->session()->regenerateToken();

//     return redirect()->route('login');
// }

}
