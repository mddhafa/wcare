<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan - Sistem Curhat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0fdf4;
            color: #334155;
        }

        .main-container {
            padding: 3rem 0;
            min-height: 100vh;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            background: white;
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            padding: 2rem;
            border-bottom: none;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            background-color: #ecfdf5;
            color: #059669;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table-custom th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            padding: 1.2rem 1.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-custom td {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        .table-hover tbody tr:hover {
            background-color: #f0fdf4;
        }

        .btn-back {
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            background-color: white;
            color: #059669;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .btn-back:hover {
            background-color: #ecfdf5;
            color: #047857;
            transform: translateY(-2px);
        }

        .search-box {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 0.6rem 1.2rem 0.6rem 2.5rem;
            width: 100%;
            min-width: 250px;
            color: white;
            transition: all 0.3s;
        }

        .search-box::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }

        .search-box:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .status-badge {
            padding: 0.5em 1em;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.75rem;
            border: 1px solid transparent;
        }

        .status-pending {
            background-color: #fffbeb;
            color: #b45309;
            border-color: #fcd34d;
        }

        .status-proses {
            background-color: #eff6ff;
            color: #1d4ed8;
            border-color: #93c5fd;
        }

        .status-selesai {
            background-color: #f0fdf4;
            color: #15803d;
            border-color: #86efac;
        }
    </style>
</head>

<body>

    @include('components.navbar')

    {{-- Tentukan Link Kembali berdasarkan Role --}}
    @php
    $backRoute = route('dashboard');
    if(Auth::user()->role_id == 1) $backRoute = route('admin.dashboard');
    elseif(Auth::user()->role_id == 2) $backRoute = route('psikolog.dashboard-psikolog');
    @endphp

    <div class="container main-container">

        <div class="card card-custom">

            <div class="card-header-custom">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-4">

                    <div class="d-flex align-items-center gap-4 w-100 w-lg-auto">
                        <a href="{{ $backRoute }}" class="btn btn-back shadow-sm" data-bs-toggle="tooltip" title="Kembali ke Dashboard">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            @if(Auth::user()->role_id == 3)
                            <h4 class="fw-bold mb-0 text-white">Riwayat Laporan</h4>
                            <div class="d-flex align-items-center gap-2 text-white text-opacity-75 small">
                                <i class="bi bi-archive-fill"></i>
                                <span>Pantau status laporan Anda</span>
                            </div>
                            @elseif(Auth::user()->role_id == 2)
                            <h4 class="fw-bold mb-0 text-white">Tugas Laporan</h4>
                            <div class="d-flex align-items-center gap-2 text-white text-opacity-75 small">
                                <i class="bi bi-clipboard-data-fill"></i>
                                <span>Daftar laporan yang perlu ditangani</span>
                            </div>
                            @else
                            <h4 class="fw-bold mb-0 text-white">Daftar Laporan Masuk</h4>
                            <div class="d-flex align-items-center gap-2 text-white text-opacity-75 small">
                                <i class="bi bi-inbox-fill"></i>
                                <span id="totalCount">{{ $laporan->count() }}</span><span> total laporan</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-3 w-100 w-lg-auto">
                        <div class="position-relative flex-grow-1 flex-lg-grow-0">
                            <i class="bi bi-search position-absolute text-white text-opacity-75" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                            <input type="text" id="searchInput" class="search-box" placeholder="Cari pelapor, jenis, atau lokasi...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0" id="laporanTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="20%">Tanggal</th>
                                @if(Auth::user()->role_id != 3)
                                <th width="20%">Pelapor</th>
                                @endif
                                <th width="15%">Jenis</th>
                                <th width="15%">Status</th>
                                <th width="15%">Psikolog</th>
                                <th width="10%" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporan as $index => $l)
                            <tr class="data-row">
                                <td class="text-center text-muted loop-number">{{ $index + 1 }}</td>

                                <td>
                                    <div class="d-flex align-items-center text-secondary">
                                        <i class="bi bi-calendar-check me-2 text-success opacity-50"></i>
                                        <div>
                                            <div class="fw-medium text-dark">{{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}</div>
                                            <small class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($l->created_at)->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>

                                @if(Auth::user()->role_id != 3)
                                <td class="search-pelapor">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 flex-shrink-0 border border-success border-opacity-25">
                                            {{ strtoupper(substr($l->korban->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <span class="fw-medium text-dark">{{ $l->korban->name ?? 'Anonim' }}</span>
                                    </div>
                                </td>
                                @endif

                                <td class="search-jenis">
                                    <div class="fw-medium text-dark">{{ $l->jenis }}</div>
                                    <small class="text-muted d-block search-lokasi"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($l->lokasi, 15) }}</small>
                                </td>

                                <td>
                                    <span class="status-badge status-{{ $l->status }}">
                                        @if($l->status == 'pending') <i class="bi bi-hourglass-split me-1"></i>
                                        @elseif($l->status == 'proses') <i class="bi bi-arrow-repeat me-1"></i>
                                        @else <i class="bi bi-check-circle-fill me-1"></i>
                                        @endif
                                        {{ ucfirst($l->status) }}
                                    </span>
                                </td>

                                <td>
                                    @if($l->psikolog)
                                    <div class="text-dark fw-medium small">{{ $l->psikolog->user->name }}</div>
                                    @else
                                    <span class="badge bg-light text-muted border fw-normal">-</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('lapor.show', $l->id) }}" class="btn btn-sm btn-light text-primary border rounded-pill shadow-sm px-3 fw-bold">
                                        Detail <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr id="noDataRow">
                                <td colspan="7" class="text-center py-5 text-muted bg-light">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                        <div class="bg-white p-3 rounded-circle shadow-sm mb-3">
                                            <i class="bi bi-inbox text-secondary display-6"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Tidak ada laporan</h6>
                                        <p class="mb-0 small">Belum ada data laporan yang tersedia saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                            <tr id="noSearchFound" style="display: none;">
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                        <i class="bi bi-search text-secondary fs-1 mb-3 opacity-50"></i>
                                        <h6 class="fw-bold text-dark">Tidak Ditemukan</h6>
                                        <p class="mb-0 small">Laporan yang Anda cari tidak tersedia.</p>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-top py-3">
                <small class="text-muted">Menampilkan semua data laporan</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('.data-row');
            let hasResult = false;

            rows.forEach(row => {
                let pelapor = row.querySelector('.search-pelapor') ? row.querySelector('.search-pelapor').innerText.toLowerCase() : '';
                let jenis = row.querySelector('.search-jenis').innerText.toLowerCase();
                let lokasi = row.querySelector('.search-lokasi') ? row.querySelector('.search-lokasi').innerText.toLowerCase() : '';

                if (pelapor.includes(filter) || jenis.includes(filter) || lokasi.includes(filter)) {
                    row.style.display = '';
                    hasResult = true;
                } else {
                    row.style.display = 'none';
                }
            });

            let noDataRow = document.getElementById('noDataRow');
            let noSearchFound = document.getElementById('noSearchFound');

            if (!noDataRow) {
                if (hasResult) {
                    noSearchFound.style.display = 'none';
                } else {
                    noSearchFound.style.display = '';
                }
            }
        });
    </script>
</body>

</html>