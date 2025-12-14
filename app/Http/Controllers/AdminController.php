<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id != 1) abort(403);

        $stats = [
            'total_laporan' => Laporan::count(),
            'laporan_pending' => Laporan::where('status', 'pending')->count(),
            'laporan_selesai' => Laporan::where('status', 'selesai')->count(),
            'total_korban' => User::where('role_id', 3)->count(),
            'total_psikolog' => User::where('role_id', 2)->count(),
        ];

        $laporan_terbaru = Laporan::with('korban')->latest()->take(5)->get();

        return view('Admin.dashboard-admin', compact('stats', 'laporan_terbaru'));
    }

    public function mahasiswa()
    {
        if (Auth::user()->role_id != 1) abort(403);
        $users = User::where('role_id', 3)->with('korban')->latest()->get();
        return view('Admin.mahasiswa-index', compact('users'));
    }

    public function psikolog()
    {
        if (Auth::user()->role_id != 1) abort(403);
        $users = User::where('role_id', 2)->with('psikolog')->latest()->get();
        return view('Admin.psikolog-index', compact('users'));
    }

    public function createPsikolog()
    {
        if (Auth::user()->role_id != 1) abort(403);
        return view('Admin.psikolog-create');
    }

    public function storePsikolog(Request $request)
    {
        if (Auth::user()->role_id != 1) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after:jam_mulai',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2,
                'active_status' => 0,
                'email_verified_at' => now(),
            ]);

            \App\Models\Psikolog::create([
                'user_id' => $user->user_id,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]);

            return redirect()->route('admin.psikolog')->with('success', 'Psikolog berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menambahkan data: ' . $e->getMessage()]);
        }
    }

    public function destroyUser($id)
    {
        if (Auth::user()->role_id != 1) abort(403);

        $user = User::findOrFail($id);

        if ($user->user_id == Auth::user()->user_id) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus akun sendiri!']);
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus sementara (masuk sampah).');
    }

    public function trashUsers()
    {
        if (Auth::user()->role_id != 1) abort(403);
        $deletedUsers = User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('Admin.users-trash', compact('deletedUsers'));
    }

    public function restoreUser($id)
    {
        if (Auth::user()->role_id != 1) abort(403);
        User::withTrashed()->where('user_id', $id)->restore();
        return back()->with('success', 'User berhasil dikembalikan.');
    }

    public function forceDeleteUser($id)
    {
        if (Auth::user()->role_id != 1) abort(403);

        User::withTrashed()->where('user_id', $id)->forceDelete();

        return back()->with('success', 'User berhasil dihapus PERMANEN.');
    }

    public function editUser($id)
    {
        if (Auth::user()->role_id != 1) abort(403);

        $user = User::with(['korban', 'psikolog'])->findOrFail($id);

        return view('Admin.user-edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        if (Auth::user()->role_id != 1) abort(403);

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $user->update($updateData);

        if ($user->role_id == 3) {
            $request->validate([
                'umur' => 'nullable|integer',
                'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            ]);

            $user->korban()->updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'umur' => $request->umur,
                    'jenis_kelamin' => $request->jenis_kelamin
                ]
            );
        } elseif ($user->role_id == 2) {
            $request->validate([
                'jadwal_tersedia' => 'nullable|date',
            ]);

            $user->psikolog()->updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'jadwal_tersedia' => $request->jadwal_tersedia
                ]
            );
        }

        $route = $user->role_id == 2 ? 'admin.psikolog' : 'admin.mahasiswa';
        return redirect()->route($route)->with('success', 'Data user berhasil diperbarui.');
    }
}
