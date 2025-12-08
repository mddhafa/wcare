<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Laporan Selesai - Sistem Curhat</title>
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
                    <h2 class="fw-bold mb-1" style="color: #059669;">Arsip Laporan Selesai</h2>
                    <p class="text-muted mb-0">Riwayat kasus yang telah ditangani dan diselesaikan.</p>
                </div>
                <a href="{{ url('/psikolog/dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-grid me-1"></i> Dashboard
                </a>
            </div>

            <div class="card card-custom overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Pelapor</th>
                                    <th>Jenis</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($laporan as $index => $l)
                                <tr>
                                    <td class="ps-4">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-medium">{{ \Carbon\Carbon::parse($l->updated_at)->format('d M Y') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($l->updated_at)->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle text-secondary fs-5 me-2"></i>
                                            <span class="fw-medium">{{ $l->korban->name ?? 'Anonim' }}</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ $l->jenis }}</span></td>
                                    <td>{{ Str::limit($l->lokasi, 20) }}</td>
                                    <td>
                                        <span class="badge-status status-selesai">
                                            {{ $l->status }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('lapor.show', $l->id) }}" class="btn btn-sm btn-success">
                                            <i class="bi bi-eye"></i> Tinjau Kembali
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="60" class="mb-3 opacity-50">
                                        <p class="mb-0">Belum ada arsip laporan selesai.</p>
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