<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SelfHealingRequest;
use App\Models\SelfHealing;

class SelfHealingController extends Controller
{

    public function index()
    {
        // $selfHealings = SelfHealing::latest()->get();
        $selfHealings = SelfHealing::all();

        return view('halamanselfhealing', compact('selfHealings'));
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
            $selfHealing->jenis_konten = $request->jenis_konten;
            $selfHealing->judul = $request->judul;
            $selfHealing->link_konten = $request->link_konten;
            $selfHealing->deskripsi = $request->deskripsi;

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
        return view('admin.tambahkonten');
    }


}