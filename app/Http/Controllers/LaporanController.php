<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function create()
    {
        return view('lapor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required',
            'jenis' => 'required',
            'kronologi' => 'required',
            'tanggal' => 'required|date',
        ]);

        Laporan::create([
            'user_id' => Auth::id(), 
            'lokasi' => $request->lokasi,
            'jenis' => $request->jenis,
            'kronologi' => $request->kronologi,
            'tanggal' => $request->tanggal,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Laporan berhasil dikirim. Konselor kami akan segera meninjaunya.');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 3) {
            $laporan = Laporan::where('user_id', $user->user_id)
                ->latest()
                ->get();
        } else {
            $laporan = Laporan::with('korban')->latest()->get();
        }

        return view('lapor.index', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = Laporan::with('korban')->findOrFail($id);

        if (Auth::user()->role_id == 3 && $laporan->user_id != Auth::user()->user_id) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        return view('lapor.show', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        if (!in_array(Auth::user()->role_id, [1, 2])) {
            abort(403, 'Hanya Psikolog yang dapat mengubah status.');
        }

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}
