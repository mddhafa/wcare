<?php

namespace App\Http\Controllers;

use App\Models\Emosi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmosiController extends Controller
{
    public function pilihEmosi(Request $request)
    {
        $request->validate([
            'emosi_id' => 'required|exists:emosi,id_emosi',
        ]);

        $user = Auth::user();
        $user->current_emosi_id = $request->emosi_id;
        $user->save();

        return back()->with('success', 'Emosi berhasil disimpan!');
    }
}
