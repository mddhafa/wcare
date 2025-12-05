<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - Sistem Curhat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
        }

        .status-card {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .timeline-dot {
            width: 12px;
            height: 12px;
            background: #e5e7eb;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .timeline-dot.active {
            background: #059669;
            box-shadow: 0 0 0 4px #d1fae5;
        }
    </style>
</head>

<body>
    @include('components.navbar')

    <div class="container py-5">
        <div class="row">

            <div class="col-lg-8 mb-4">
                <a href="{{ route('lapor.index') }}" class="btn btn-light mb-3 text-muted"><i class="bi bi-arrow-left"></i> Kembali</a>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white p-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary mb-2">{{ $laporan->jenis }}</span>
                                <h4 class="fw-bold mb-1">Laporan #{{ $laporan->id }}</h4>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i> Diajukan pada {{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d F Y, H:i') }}
                                </small>
                            </div>
                            @php
                            $statusColor = match($laporan->status) {
                            'pending' => 'warning',
                            'proses' => 'primary',
                            'selesai' => 'success',
                            default => 'secondary'
                            };
                            @endphp
                            <span class="badge bg-{{ $statusColor }} fs-6 px-3 py-2 rounded-pill text-uppercase">
                                {{ $laporan->status }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="fw-bold text-muted small text-uppercase">Pelapor</label>
                            <div class="d-flex align-items-center mt-2">
                                <div class="bg-light rounded-circle p-2 me-3"><i class="bi bi-person fs-4"></i></div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $laporan->korban->name ?? 'Anonim' }}</h6>
                                    <small class="text-muted">{{ $laporan->korban->email ?? '-' }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-muted small text-uppercase">Lokasi & Tanggal Kejadian</label>
                            <p class="mt-1 fs-5">
                                <i class="bi bi-geo-alt text-danger me-2"></i> {{ $laporan->lokasi }} <br>
                                <i class="bi bi-calendar-event text-primary me-2"></i> {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d F Y') }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold text-muted small text-uppercase">Kronologi Kejadian</label>
                            <div class="p-3 bg-light rounded-3 mt-2" style="white-space: pre-line; line-height: 1.8;">
                                {{ $laporan->kronologi }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                <div class="card status-card mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Tindakan Psikolog</h5>
                        <p class="text-muted small mb-3">Ubah status laporan ini untuk memberitahu korban mengenai perkembangan kasus.</p>

                        <form action="{{ route('lapor.update', $laporan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="d-grid gap-2">
                                @if($laporan->status == 'pending')
                                <button name="status" value="proses" class="btn btn-primary py-2 fw-semibold">
                                    <i class="bi bi-arrow-repeat me-2"></i> Proses Laporan
                                </button>
                                @endif

                                @if($laporan->status == 'proses')
                                <button name="status" value="selesai" class="btn btn-success py-2 fw-semibold">
                                    <i class="bi bi-check-circle-fill me-2"></i> Tandai Selesai
                                </button>
                                @endif

                                @if($laporan->status == 'selesai')
                                <div class="alert alert-success text-center mb-0">
                                    <i class="bi bi-check-circle-fill me-1"></i> Kasus Selesai
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <div class="card status-card">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Tracking Status</h5>

                        <div class="d-flex align-items-center mb-3">
                            <div class="timeline-dot {{ in_array($laporan->status, ['pending', 'proses', 'selesai']) ? 'active' : '' }}"></div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0 fw-semibold">Laporan Masuk</h6>
                                <small class="text-muted">Laporan telah diterima sistem.</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="timeline-dot {{ in_array($laporan->status, ['proses', 'selesai']) ? 'active' : '' }}"></div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0 fw-semibold">Sedang Diproses</h6>
                                <small class="text-muted">Psikolog sedang meninjau kasus.</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="timeline-dot {{ $laporan->status == 'selesai' ? 'active' : '' }}"></div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0 fw-semibold">Selesai</h6>
                                <small class="text-muted">Kasus telah ditutup/diselesaikan.</small>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('components.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: "#059669"
        });
    </script>
    @endif
</body>

</html>