<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Psikolog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

        if ($user->role_id == 2) {

        $psikolog = Psikolog::where('user_id', $user->user_id)->first();

            if (!$psikolog) {
                $laporan = collect(); 
            } else {
                $laporan = Laporan::with(['korban', 'psikolog.user'])
                    ->where('assigned_psikolog_id', $psikolog->id_psikolog)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }
        elseif ($user->role_id == 3) {
            $laporan = Laporan::where('user_id', $user->user_id)
                            ->latest()
                            ->get();
        }
        elseif($user->role_id == 3){
            $laporan = Laporan::with('korban')
                ->where('status', '!=', 'selesai') // Default index tidak menampilkan yang selesai
                ->latest()
                ->get();
        }
        else {
            $laporan = Laporan::orderBy('created_at', 'desc')->get();
        }

        return view('lapor.index', compact('laporan'));
    }

    public function arsip()
    {
        if (!in_array(Auth::user()->role_id, [1, 2])) {
            abort(403, 'Akses Ditolak');
        }
        $user = Auth::user();
        $psikolog = Psikolog::where('user_id', $user->user_id)->first();

        $laporan = Laporan::with('korban')
            ->where('status', 'selesai')
            ->where('assigned_psikolog_id', $psikolog->id_psikolog)
            ->latest()
            ->get();

        return view('lapor.arsip', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = Laporan::with('korban')->findOrFail($id);

        if (Auth::user()->role_id == 3 && $laporan->user_id != Auth::user()->user_id) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        $psikologs = Psikolog::with('user')->orderBy('id_psikolog')->get();

        return view('lapor.show', compact('laporan', 'psikologs'));
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

    // Assign laporan ke psikolog (hanya admin)
   public function assign(Request $request, Laporan $laporan)
    {
        \Log::info('Request data:', $request->all());
        if (Auth::user()->role_id != 1) {
            abort(403, 'Hanya admin yang dapat melakukan assign.');
        }

        $request->validate([
            'id_psikolog' => 'nullable|exists:psikolog,id_psikolog',
        ]);

        $psikologId = $request->id_psikolog;

        if ($psikologId) {
            $laporan->assigned_psikolog_id = $psikologId;
            $laporan->assigned_at = now();
            $laporan->status = 'proses';
        } else {
            $laporan->assigned_psikolog_id = null;
            $laporan->assigned_at = null;
            $laporan->status = 'pending';
        }

        $laporan->save();

        return back()->with('success', $psikologId 
            ? 'Laporan berhasil di-assign ke psikolog.'
            : 'Laporan berhasil di-unassign.');
    }


    public function unassign(Laporan $laporan)
    {
        $user = Auth::user();

        if ($user->role_id != 1) {
            abort(403, 'Hanya admin yang dapat membatalkan assign.');
        }

        $laporan->assigned_psikolog_id = null;
        $laporan->assigned_at = null;
        $laporan->status = 'pending';
        $laporan->save();

        return redirect()->back()->with('success', 'Assign dibatalkan.');
    }

}
