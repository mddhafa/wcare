<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan - Sistem Curhat</title>
    <!-- Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ecfdf5;
        }

        .main-container {
            padding: 3rem 0;
            min-height: 100vh;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .table-custom th {
            background-color: #f9fafb;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #6b7280;
        }

        .badge-status {
            padding: 0.5em 0.75em;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: capitalize;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #b45309;
        }

        .status-proses {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-selesai {
            background-color: #d1fae5;
            color: #065f46;
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <div class="main-container">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <!-- Judul Dinamis -->
                    @if(Auth::user()->role_id == 3)
                        {{-- KORBAN --}}
                        <h2 class="fw-bold mb-1" style="color: #059669;">Riwayat Laporan Saya</h2>
                        <p class="text-muted mb-0">Pantau status laporan yang pernah Anda kirimkan.</p>

                    @elseif(Auth::user()->role_id == 2)
                        {{-- PSIKOLOG --}}
                        <h2 class="fw-bold mb-1" style="color: #059669;">Laporan yang Ditugaskan ke Saya</h2>
                        <p class="text-muted mb-0">Daftar laporan yang diberikan admin untuk Anda tangani.</p>

                    @else
                        {{-- ADMIN --}}
                        <h2 class="fw-bold mb-1" style="color: #059669;">Daftar Laporan Masuk</h2>
                        <p class="text-muted mb-0">Kelola semua laporan dari mahasiswa.</p>
                    @endif
                </div>

                <!-- TOMBOL KEMBALI DINAMIS -->
                @if(Auth::user()->role_id == 1)
                <!-- ADMIN -->
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-grid me-1"></i> Dashboard Admin
                </a>
                @elseif(Auth::user()->role_id == 2)
                <!-- PSIKOLOG -->
                <a href="{{ route('psikolog.dashboard-psikolog') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-grid me-1"></i> Dashboard Psikolog
                </a>
                @else
                <!-- KORBAN -->
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Dashboard
                </a>
                @endif
            </div>

            <div class="card card-custom overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Tanggal</th>
                                    @if(Auth::user()->role_id != 3) <th>Pelapor</th> @endif
                                    <th>Jenis</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Psikolog</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporan as $index => $l)
                                <tr>
                                    <td class="ps-4">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-medium">{{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($l->created_at)->diffForHumans() }}</small>
                                    </td>
                                    @if(Auth::user()->role_id != 3)
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle text-secondary fs-5 me-2"></i>
                                            <span class="fw-medium">{{ $l->korban->name ?? 'Anonim' }}</span>
                                        </div>
                                    </td>
                                    @endif
                                    <td><span class="badge bg-light text-dark border">{{ $l->jenis }}</span></td>
                                    <td>{{ Str::limit($l->lokasi, 20) }}</td>
                                    <td>
                                        <span class="badge-status status-{{ $l->status }}">
                                            {{ $l->status }}
                                        </span>
                                    </td>
                                    <td> {{ $l->psikolog->user->name ?? '-' }} </td>
                                    <td class="text-end pe-4">
                                        <!-- Tombol Lihat Detail -->
                                        <a href="{{ route('lapor.show', $l->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="60" class="mb-3 opacity-50">
                                        <p class="mb-0">Belum ada data laporan.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>