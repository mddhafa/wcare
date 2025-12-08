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

        // Default: Ambil semua konten
        $selfHealings = SelfHealing::with('emosi')->latest()->get();
        $currentEmosi = null;

        // Logika Filter jika User Login & Punya Emosi
        if ($user && $user->current_emosi_id) {
            // Cek apakah kolom id_emosi ada di tabel selfhealing
            if (Schema::hasColumn('selfhealing', 'id_emosi')) {
                $filtered = SelfHealing::with('emosi')
                    ->where('id_emosi', $user->current_emosi_id)
                    ->latest()
                    ->get();

                // Jika ada konten yang cocok, pakai yang difilter
                if ($filtered->isNotEmpty()) {
                    $selfHealings = $filtered;
                    $currentEmosi = Emosi::find($user->current_emosi_id);
                }
            }
        }

        return view('halamanselfhealing', compact('selfHealings', 'currentEmosi'));
    }

    // --- DASHBOARD WIDGET ---
    public function indexdash()
    {
        $selfHealings = SelfHealing::latest()->take(5)->get();
        return view('dashboard', compact('selfHealings'));
    }

    // --- DETAIL KONTEN (API/Show) ---
    public function show($id)
    {
        $selfHealing = SelfHealing::find($id);
        if (!$selfHealing) {
            return response()->json(['message' => 'Konten tidak ditemukan'], 404);
        }
        return response()->json(['data' => $selfHealing], 200);
    }

    // --- FORM TAMBAH KONTEN (ADMIN) ---
    public function tambahkonten()
    {
        $emosis = Emosi::all();
        return view('Admin.tambahkonten', compact('emosis'));
    }

    // --- PROSES SIMPAN KONTEN (ADMIN) ---
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'jenis_konten' => 'required|string|max:255',
            'id_emosi'     => 'required|exists:emosi,id_emosi', // Pastikan nama tabel & kolom PK sesuai
            'judul'        => 'required|string|max:255',
            'link_konten'  => 'nullable|url',
            'deskripsi'    => 'required|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
        ]);

        try {
            $selfHealing = new SelfHealing();
            $selfHealing->jenis_konten = $request->jenis_konten;
            $selfHealing->id_emosi     = $request->id_emosi;
            $selfHealing->judul        = $request->judul;
            $selfHealing->link_konten  = $request->link_konten;
            $selfHealing->deskripsi    = $request->deskripsi;

            // 2. Upload Gambar (Jika ada)
            if ($request->hasFile('gambar')) {
                // Simpan di folder: storage/app/public/selfhealing
                $path = $request->file('gambar')->store('selfhealing', 'public');
                $selfHealing->gambar = $path;
            }

            $selfHealing->save();

            // Redirect dengan pesan sukses
            return redirect()->route('halamanselfhealing')->with('success', 'Konten berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Jika error, kembali ke form dengan pesan error
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }
}
