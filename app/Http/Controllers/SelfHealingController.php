<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SelfHealing;
use App\Models\Emosi;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SelfHealingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $selfHealings = SelfHealing::with('emosi')->latest()->get();
        $currentEmosi = null;

        if ($user && $user->current_emosi_id) {
            if (Schema::hasColumn('selfhealing', 'id_emosi')) {
                $filtered = SelfHealing::with('emosi')
                    ->where('id_emosi', $user->current_emosi_id)
                    ->latest()
                    ->get();

                if ($filtered->isNotEmpty()) {
                    $selfHealings = $filtered;
                    $currentEmosi = Emosi::find($user->current_emosi_id);
                }
            }
        }

        return view('halamanselfhealing', compact('selfHealings', 'currentEmosi'));
    }

    public function indexdash()
    {
        $selfHealings = SelfHealing::latest()->take(5)->get();
        return view('dashboard', compact('selfHealings'));
    }

    public function show($id)
    {
        $selfHealing = SelfHealing::find($id);
        if (!$selfHealing) {
            return response()->json(['message' => 'Konten tidak ditemukan'], 404);
        }
        return response()->json(['data' => $selfHealing], 200);
    }

    public function tambahkonten()
    {
        $emosis = Emosi::all();
        return view('Admin.tambahkonten', compact('emosis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_konten' => 'required|string|max:255',
            'id_emosi'     => 'required|exists:emosi,id_emosi',
            'judul'        => 'required|string|max:255',
            'link_konten'  => 'nullable|url',
            'deskripsi'    => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',

            'audio'        => 'nullable|file|mimes:mp3,wav,ogg,m4a,mpeg,bin,mp4|max:20480',
        ]);

        try {
            $selfHealing = new SelfHealing();
            $selfHealing->jenis_konten = $request->jenis_konten;
            $selfHealing->id_emosi     = $request->id_emosi;
            $selfHealing->judul        = $request->judul;
            $selfHealing->link_konten  = $request->link_konten;
            $selfHealing->deskripsi    = $request->deskripsi;

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $selfHealing->gambar = file_get_contents($file->getRealPath());
                $selfHealing->gambar_mime = $file->getMimeType();
            }

            if ($request->hasFile('audio')) {
                $file = $request->file('audio');
                $selfHealing->audio = file_get_contents($file->getRealPath());
                $selfHealing->audio_mime = $file->getMimeType();
            }

            $selfHealing->save();

            return redirect()->route('halamanselfhealing')->with('success', 'Konten berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    public function gambar($id)
    {
        $row = SelfHealing::findOrFail($id);
        if (!$row->gambar) abort(404);
        
        $mime = $row->gambar_mime ?? 'image/jpeg';

        return response($row->gambar)
            ->header('Content-Type', 'image/jpeg');
    }

    public function audio($id)
    {
        $row = SelfHealing::findOrFail($id);
        if (!$row->audio) abort(404);

        return response($row->audio)
            ->header('Content-Type', 'audio/mpeg');
    }


    public function destroy($id)
    {
        if (Auth::user()->role_id != 1) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus konten ini.');
        }

        try {
           $selfHealing = SelfHealing::findOrFail($id);
            $selfHealing->delete();
            return back()->with('success', 'Konten berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus konten: ' . $e->getMessage()]);
        }
    }
}
