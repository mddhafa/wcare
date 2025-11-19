<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SelfHealingRequest;
use App\Models\SelfHealing;
use Illuminate\Support\Facades\Schema;
use Illuminatr\Support\Facades\Log;
use App\Models\Emosi;

class SelfHealingController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        
        // Debug: Log user info
        \Log::info('=== START DEBUG SELF HEALING ===');
        \Log::info('User: ' . ($user ? $user->id : 'Guest'));
        \Log::info('Current Emosi ID: ' . ($user ? $user->current_emosi_id : 'NULL'));

        try {
            if ($user && $user->current_emosi_id) {
                \Log::info('User memiliki emosi ID: ' . $user->current_emosi_id);
                
                // Cek apakah kolom emosi_id ada
                if (Schema::hasColumn('selfhealing', 'id_emosi')) {
                    \Log::info('Kolom emosi_id DITEMUKAN');
                    
                    // Filter konten berdasarkan emosi user
                    $selfHealings = SelfHealing::where('id_emosi', $user->current_emosi_id)->get();
                    
                    \Log::info('Jumlah konten filtered: ' . $selfHealings->count());
                    
                    // Debug: tampilkan ID konten yang ditemukan
                    $ids = $selfHealings->pluck('id')->toArray();
                    \Log::info('ID Konten yang ditemukan: ' . implode(', ', $ids));
                    
                    // Jika tidak ada konten untuk emosi ini, tampilkan semua
                    if ($selfHealings->isEmpty()) {
                        \Log::warning('TIDAK ADA konten untuk emosi ID: ' . $user->current_emosi_id);
                        \Log::info('Menampilkan SEMUA konten sebagai fallback');
                        $selfHealings = SelfHealing::all();
                    } else {
                        \Log::info('BERHASIL filter konten berdasarkan emosi');
                    }
                } else {
                    \Log::error('Kolom emosi_id TIDAK DITEMUKAN!');
                    $selfHealings = SelfHealing::all();
                }
            } else {
                \Log::info('User BELUM memilih emosi atau belum login');
                $selfHealings = SelfHealing::all();
            }
            
            \Log::info('Total konten yang akan ditampilkan: ' . $selfHealings->count());
            \Log::info('=== END DEBUG SELF HEALING ===');
            
        } catch (\Exception $e) {
            \Log::error('ERROR: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            $selfHealings = SelfHealing::all();
        }

        // Ambil data emosi user untuk ditampilkan di view
        $currentEmosi = $user && $user->current_emosi_id ? 
                        Emosi::find($user->current_emosi_id) : null;

        return view('halamanselfhealing', compact('selfHealings', 'currentEmosi'));
    }
    
    public function indexdash()
    {
        $selfHealings = SelfHealing::latest()->get();
        // dd($selfHealings); // sementara untuk cek data
        return view('dashboard', compact('selfHealings'));
    }

    public function show($id)
    {
        $selfHealing = SelfHealing::find($id);
        if (!$selfHealing) {
            return response()->json([
                'message' => 'Self-healing content not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Self-healing content retrieved successfully',
            'data'    => $selfHealing,
        ], 200);
    }
    public function store(SelfHealingRequest $request)
    {
        // Cek role user
        if (($user = auth()->user()) && $user->role_id != 1) {
            return response()->json([
                'message' => 'Unauthorized: Only admins can create self-healing content',
            ], 403);
        }

        try {
            $selfHealing = new SelfHealing();
            // Isi data teks
            // $selfHealing->jenis_konten = $request->jenis_konten;
            $selfHealing->judul = $request->judul;
            $selfHealing->link_konten = $request->link_konten;
            $selfHealing->deskripsi = $request->deskripsi;
            $selfHealing->id_emosi = $request->id_emosi;

            // Upload gambar jika ada
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                // Simpan ke folder storage/app/public/selfhealing
                $path = $file->store('selfhealing', 'public');

                // Simpan path gambar ke database
                $selfHealing->gambar = $path;
            }

            $selfHealing->save();

            return redirect()->route('halamanselfhealing')->with('success', 'Self-healing content created successfully');
        } catch (\Throwable $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Self-healing content creation failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function tambahkonten()
    {
        $emosis = \App\Models\Emosi::all();
        return view('admin.tambahkonten', compact('emosis'));
    }


}