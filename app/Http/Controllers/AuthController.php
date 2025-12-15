<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;
use App\Models\Korban;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showregister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'umur' => 'required|integer|min:10',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'role_id' => 'sometimes|integer'
        ]);

        DB::beginTransaction();

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->role_id ?? 3;
            $user->active_status = 0;
            $user->save();

            if ($user->role_id == 3) {
                Korban::create([
                    'user_id' => $user->user_id,
                    'umur' => $request->umur,
                    'jenis_kelamin' => $request->jenis_kelamin
                ]);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Registrasi berhasil! Silakan login.',
                    'data'    => $user,
                ], 201);
            }

            return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Gagal melakukan registrasi',
                    'error'   => $e->getMessage(),
                ], 500);
            }
            return back()->withErrors(['error' => 'Gagal registrasi: ' . $e->getMessage()]);
        }
    }

    public function showlogin()
    {
        return view('auth.login');
    }

    public function showdashboardpsi()
    {
        return view('psikolog.dashboard-psikolog');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $user->update(['active_status' => 1]);
            $user->load('role');
            $roleName = $user->role?->name ?? 'user';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'data' => [
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $roleName,
                    ]
                ], 200);
            }

            if ($user->role_id == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role_id == 2) {
                return redirect()->route('psikolog.dashboard-psikolog');
            } else {
                return redirect()->route('dashboard');
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah'
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $user->update(['active_status' => 0]);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logout berhasil'], 200);
        }

        return redirect('/login')->with('message', 'Berhasil logout');
    }

    public function me()
    {
        $user = Auth::guard('web')->user();
        if (!$user) return response()->json(['message' => 'User tidak ditemukan'], 404);
        return response()->json(['message' => 'User ditemukan', 'data' => $user], 200);
    }

    public function refresh()
    {
        return response()->json(['message' => 'Session refreshed'], 200);
    }
}
