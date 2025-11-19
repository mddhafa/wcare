<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Korban;
use App\Models\Psikolog;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileKorbanRequest;

Class ProfileController extends Controller{

    public function index (){
        $user = auth()->user();

        $profile = Korban::where('user_id', $user->user_id)->first();

        return view('korban.profilekorban', compact('profile'));
    }

    public function addprofilekorban(ProfileKorbanRequest $request)
    {
        $user = auth()->user(); // user object
        if (!$user) {
            return redirect()->back()->with('error', 'User harus login!');
        }

        Korban::create([
            'user_id' => $user->user_id, 
            'email' => auth()->user()->email, 
            'name' => $request->name,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
        
        ]);

        return redirect()->route('korban.profilekorban')
                        ->with('success', 'Profil berhasil dibuat.');
    }

        
    public function createKorban()
    {
        return view('korban.korban-create');
    }
}