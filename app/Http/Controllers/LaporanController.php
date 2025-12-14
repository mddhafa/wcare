<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Psikolog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

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

        return back()->with('success', 'Laporan berhasil dikirim.');
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
                    ->where('status', '!=', 'selesai')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } elseif ($user->role_id == 3) {
            $laporan = Laporan::where('user_id', $user->user_id)
                ->latest()
                ->get();
        } else {
            $laporan = Laporan::orderBy('created_at', 'desc')->get();
        }

        return view('lapor.index', compact('laporan'));
    }

    public function arsip(Request $request)
    {
        if (!in_array(Auth::user()->role_id, [1, 2])) {
            abort(403, 'Akses Ditolak');
        }

        $user = Auth::user();
        $query = Laporan::with('korban')->where('status', 'selesai');

        if ($user->role_id == 2) {
            $psikolog = Psikolog::where('user_id', $user->user_id)->first();
            if ($psikolog) {
                $query->where('assigned_psikolog_id', $psikolog->id_psikolog);
            } else {
                return view('lapor.arsip', ['laporan' => collect()]);
            }
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('korban', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%");
            });
        }

        $laporan = $query->latest()->get();

        if ($request->ajax()) {
            $output = '';

            if ($laporan->count() > 0) {
                foreach ($laporan as $index => $l) {
                    $tanggal = Carbon::parse($l->updated_at)->format('d M Y');
                    $diff = Carbon::parse($l->updated_at)->diffForHumans();
                    $inisial = strtoupper(substr($l->korban->name ?? 'A', 0, 1));
                    $nama = $l->korban->name ?? 'Anonim';
                    $lokasi = Str::limit($l->lokasi, 20);
                    $url = route('lapor.show', $l->id);
                    $nomor = $index + 1;

                    $output .= '
                    <tr>
                        <td class="text-center text-muted">' . $nomor . '</td>
                        <td>
                            <div class="d-flex align-items-center text-secondary">
                                <i class="bi bi-calendar-check me-2 text-success opacity-50"></i>
                                <div>
                                    <div class="fw-medium text-dark">' . $tanggal . '</div>
                                    <small class="text-muted" style="font-size: 0.75rem;">' . $diff . '</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3 flex-shrink-0 border border-success border-opacity-25">
                                    ' . $inisial . '
                                </div>
                                <div>
                                    <div class="fw-medium text-dark">' . $nama . '</div>
                                    <small class="text-muted" style="font-size: 0.8rem;">
                                        <i class="bi bi-geo-alt me-1"></i> ' . $lokasi . '
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                ' . $l->jenis . '
                            </span>
                        </td>
                        <td>
                            <span class="badge-status status-selesai">
                                <i class="bi bi-check-circle-fill me-1"></i> Selesai
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="' . $url . '" class="btn btn-sm btn-outline-success rounded-pill fw-bold px-3 shadow-sm">
                                <i class="bi bi-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>';
                }
            } else {
                $output = '
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted bg-light">
                        <div class="d-flex flex-column align-items-center justify-content-center py-4">
                            <div class="bg-white p-3 rounded-circle shadow-sm mb-3">
                                <i class="bi bi-search text-secondary display-6 opacity-50"></i>
                            </div>
                            <h6 class="fw-bold text-dark">Data Tidak Ditemukan</h6>
                            <p class="mb-0 small text-muted">Tidak ada laporan yang cocok dengan pencarian Anda.</p>
                        </div>
                    </td>
                </tr>';
            }

            return response($output);
        }

        return view('lapor.arsip', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = Laporan::with('korban')->findOrFail($id);

        if (Auth::user()->role_id == 3 && $laporan->user_id != Auth::user()->user_id) {
            abort(403, 'Akses Ditolak');
        }

        $psikologs = Psikolog::with('user')->orderBy('id_psikolog')->get();

        return view('lapor.show', compact('laporan', 'psikologs'));
    }

    public function update(Request $request, $id)
    {
        if (!in_array(Auth::user()->role_id, [1, 2])) {
            abort(403, 'Akses Ditolak');
        }

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status laporan diperbarui.');
    }

    public function assign(Request $request, Laporan $laporan)
    {
        Log::info('Request data:', $request->all());
        if (Auth::user()->role_id != 1) {
            abort(403, 'Akses Ditolak');
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

        return back()->with('success', 'Assign berhasil.');
    }

    public function unassign(Laporan $laporan)
    {
        if (Auth::user()->role_id != 1) {
            abort(403, 'Akses Ditolak');
        }

        $laporan->assigned_psikolog_id = null;
        $laporan->assigned_at = null;
        $laporan->status = 'pending';
        $laporan->save();

        return redirect()->back()->with('success', 'Assign dibatalkan.');
    }
}
