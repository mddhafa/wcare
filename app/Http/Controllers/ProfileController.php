<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Korban;
use App\Models\Psikolog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->role_id == 2) {
            $profile = $user->psikolog;
            return view('psikolog.profile', compact('user', 'profile'));
        } elseif ($user->role_id == 3) {
            $profile = $user->korban;
            return view('profile.index', compact('user', 'profile'));
        }

        return redirect()->route('dashboard');
    }

    public function edit()
    {
        $user = Auth::user();

        if ($user->role_id == 2) {
            $profile = $user->psikolog;
        } elseif ($user->role_id == 3) {
            $profile = $user->korban;
        } else {
            $profile = null;
        }

        return view('profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($user->role_id == 3) {

            $request->validate([
                'umur' => 'nullable|integer',
                'jenis_kelamin' => 'nullable|string',
            ]);

            Korban::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'umur' => $request->umur,
                    'jenis_kelamin' => $request->jenis_kelamin,
                ]
            );

            return redirect()->route('korban.profilekorban')->with('success', 'Profil berhasil diperbarui');
        } elseif ($user->role_id == 2) {

            $request->validate([
                'jam_mulai' => 'nullable',
                'jam_selesai' => 'nullable',
            ]);

            Psikolog::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                ]
            );

            return redirect()->route('psikolog.profilepsikolog')->with('success', 'Profil berhasil diperbarui');
        }

        return redirect()->back();
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::find(Auth::id());

        if ($user->avatar && $user->avatar != 'avatar.png') {
            Storage::delete('public/' . $user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui');
    }
}
