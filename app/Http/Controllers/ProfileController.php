<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = null;

        if ($user->role_id == 3) {
            $profile = $user->korban;
        } elseif ($user->role_id == 2) {
            $profile = $user->psikolog;
        }

        return view('profile.index', compact('profile'));
    }

    // --- FORM EDIT PROFILE ---
    public function edit()
    {
        $user = Auth::user();
        $profile = null;

        if ($user->role_id == 3) {
            $profile = $user->korban;
        } elseif ($user->role_id == 2) {
            $profile = $user->psikolog;
        }

        return view('profile.edit', compact('user', 'profile'));
    }

    // --- PROSES UPDATE PROFILE ---
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Dasar (Tabel User)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
        ]);

        // 2. Update Tabel User
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // 3. Update Tabel Detail (Sesuai Role)
        if ($user->role_id == 3) { // Korban
            $request->validate([
                'umur' => 'required|integer',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            ]);

            // updateOrCreate: Jika belum ada data, dibuatkan. Jika ada, diupdate.
            $user->korban()->updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'umur' => $request->umur,
                    'jenis_kelamin' => $request->jenis_kelamin
                ]
            );
        } elseif ($user->role_id == 2) { // Psikolog
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

        return redirect()->route('korban.profilekorban')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            if ($user->avatar && $user->avatar != 'avatar.png') {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}
