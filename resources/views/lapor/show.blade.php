<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan #{{ $laporan->id }} - Sistem Curhat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0fdf4;
            color: #334155;
        }

        .main-container {
            padding: 3rem 0;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background: white;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            padding: 2rem;
            border-bottom: none;
        }

        .btn-back {
            background-color: white;
            color: #059669;
            border-radius: 50px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-back:hover {
            background-color: #ecfdf5;
            color: #047857;
            transform: translateY(-2px);
        }

        .timeline-wrapper {
            padding-left: 1rem;
            border-left: 2px solid #e2e8f0;
            margin-left: 0.5rem;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            width: 12px;
            height: 12px;
            background: #fff;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            position: absolute;
            left: -23px;
            top: 5px;
        }

        .timeline-item.active::before {
            background: #059669;
            border-color: #059669;
            box-shadow: 0 0 0 3px #d1fae5;
        }

        .avatar-circle-detail {
            width: 55px;
            height: 55px;
            background-color: #ecfdf5;
            color: #059669;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.5rem;
            border: 2px solid #a7f3d0;
        }

        .avatar-img-detail {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #a7f3d0;
        }

        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <div class="container main-container">

        <div class="card card-custom mb-4">
            <div class="card-header-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        @php
                        $backRoute = route('lapor.index');
                        if($laporan->status == 'selesai' && Auth::user()->role_id == 2) {
                        $backRoute = route('lapor.arsip');
                        }
                        @endphp
                        <a href="{{ $backRoute }}" class="btn-back">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h4 class="fw-bold mb-0 text-white">Laporan #{{ $laporan->id }}</h4>
                            <div class="text-white text-opacity-75 small">
                                <i class="bi bi-clock me-1"></i> Diajukan: {{ \Carbon\Carbon::parse($laporan->created_at)->translatedFormat('d F Y, H:i') }}
                            </div>
                        </div>
                    </div>

                    @php
                    $statusClass = match($laporan->status) {
                    'pending' => 'bg-warning text-dark',
                    'proses' => 'bg-primary text-white',
                    'selesai' => 'bg-light text-success fw-bold',
                    'default' => 'bg-secondary'
                    };
                    @endphp
                    <span class="badge {{ $statusClass }} px-3 py-2 rounded-pill text-uppercase shadow-sm">
                        {{ $laporan->status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-8 mb-4">
                <div class="card card-custom h-100">
                    <div class="card-body p-4">

                        <div class="mb-4">
                            <div class="info-label">Pelapor</div>
                            <div class="d-flex align-items-center p-3 bg-light rounded-3 border border-light shadow-sm">

                                <div class="me-3">
                                    @php $user = $laporan->korban; @endphp
                                    @if($user)
                                    @if($user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="avatar-img-detail shadow-sm">
                                    @elseif($user->korban && $user->korban->foto && file_exists(public_path('uploads/' . $user->korban->foto)))
                                    <img src="{{ asset('uploads/' . $user->korban->foto) }}" alt="{{ $user->name }}" class="avatar-img-detail shadow-sm">
                                    @else
                                    <div class="avatar-circle-detail shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    @endif
                                    @else
                                    <div class="avatar-circle-detail bg-secondary text-white border-0">?</div>
                                    @endif
                                </div>

                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $laporan->korban->name ?? 'Anonim' }}</h6>
                                    <small class="text-muted">{{ $laporan->korban->email ?? '-' }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="info-label">Jenis & Lokasi</div>
                                <p class="mb-1 fw-medium text-dark"><i class="bi bi-tag-fill me-2 text-warning"></i> {{ $laporan->jenis }}</p>
                                <p class="mb-0 text-secondary"><i class="bi bi-geo-alt-fill me-2 text-danger"></i> {{ $laporan->lokasi }}</p>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <div class="info-label">Waktu Kejadian</div>
                                <p class="fw-medium text-dark">
                                    <i class="bi bi-calendar-check-fill me-2 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                        </div>

                        <hr class="border-light">

                        <div class="mt-4">
                            <div class="info-label">Kronologi Kejadian</div>
                            <div class="p-4 rounded-3 text-dark border border-light" style="background-color: #f8fafc; line-height: 1.8; text-align: justify;">
                                {!! nl2br(e($laporan->kronologi)) !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">

                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                <div class="card card-custom">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-dark d-flex align-items-center">
                            <i class="bi bi-sliders2 me-2 text-primary"></i> Tindakan Laporan
                        </h6>
                        <form action="{{ route('lapor.update', $laporan->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="d-grid gap-2">
                                @if($laporan->status == 'pending')
                                <button name="status" value="proses" class="btn btn-primary fw-semibold shadow-sm">
                                    <i class="bi bi-arrow-repeat me-2"></i> Proses Laporan
                                </button>
                                @elseif($laporan->status == 'proses')
                                <button name="status" value="selesai" class="btn btn-success fw-semibold shadow-sm">
                                    <i class="bi bi-check-lg me-2"></i> Selesai
                                </button>
                                @elseif($laporan->status == 'selesai')
                                <div class="alert alert-success py-2 text-center small fw-bold mb-2">
                                    <i class="bi bi-check-circle me-1"></i> Kasus Ditutup
                                </div>
                                <button name="status" value="proses" class="btn btn-outline-secondary btn-sm">
                                    Buka Kembali
                                </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                @if (Auth::user()->role_id == 1)
                <div class="card card-custom">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-dark d-flex align-items-center">
                            <i class="bi bi-person-fill-gear me-2 text-warning"></i> Petugas Psikolog
                        </h6>

                        {{-- JIKA SUDAH DITUGASKAN --}}
                        @if($laporan->assigned_psikolog_id && $laporan->psikolog)
                        <div class="bg-light p-3 rounded-3 mb-3 border border-success border-opacity-25 animate__animated animate__fadeIn">
                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">DITANGANI OLEH:</small>
                            <div class="fw-bold text-success d-flex align-items-center fs-5">
                                <i class="bi bi-person-check-fill me-2"></i>
                                {{ $laporan->psikolog->user->name ?? 'Psikolog' }}
                            </div>
                        </div>

                        {{-- Tombol Ganti / Lepas --}}
                        <form id="form-unassign-{{ $laporan->id }}" action="{{ route('admin.lapor.unassign', $laporan->id) }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-unassign fw-semibold" data-id="{{ $laporan->id }}">
                                <i class="bi bi-x-circle me-1"></i> Ganti / Batalkan Petugas
                            </button>
                        </form>

                        {{-- JIKA BELUM DITUGASKAN --}}
                        @else
                        <div class="alert alert-warning py-2 small text-center mb-3 border-warning border-opacity-25 bg-warning bg-opacity-10 text-warning text-dark fw-medium">
                            <i class="bi bi-exclamation-circle me-1"></i> Belum ada petugas assigned.
                        </div>
                        <form action="{{ route('admin.lapor.assign', $laporan->id) }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label small text-muted fw-semibold">Pilih Psikolog:</label>
                                <select name="id_psikolog" class="form-select form-select-sm" required>
                                    <option value="" selected disabled>-- Daftar Psikolog --</option>
                                    @foreach(\App\Models\Psikolog::with('user')->get() as $p)
                                    @if($p->user)
                                    <option value="{{ $p->id_psikolog }}">{{ $p->user->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-dark btn-sm w-100 fw-semibold shadow-sm">
                                <i class="bi bi-check2-square me-1"></i> Tugaskan Sekarang
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @endif

                <div class="card card-custom">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 text-dark d-flex align-items-center">
                            <i class="bi bi-activity me-2 text-info"></i> Tracking
                        </h6>
                        <div class="timeline-wrapper">
                            <div class="timeline-item {{ in_array($laporan->status, ['pending', 'proses', 'selesai']) ? 'active' : '' }}">
                                <small class="d-block fw-bold text-dark">Laporan Masuk</small>
                                <span class="text-muted" style="font-size: 0.75rem">Diterima sistem</span>
                            </div>
                            <div class="timeline-item {{ in_array($laporan->status, ['proses', 'selesai']) ? 'active' : '' }}">
                                <small class="d-block fw-bold text-dark">Diproses</small>
                                <span class="text-muted" style="font-size: 0.75rem">Sedang ditangani</span>
                            </div>
                            <div class="timeline-item {{ $laporan->status == 'selesai' ? 'active' : '' }}">
                                <small class="d-block fw-bold text-dark">Selesai</small>
                                <span class="text-muted" style="font-size: 0.75rem">Kasus ditutup</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <script>
        const currentUserRoleId = "{{ Auth::user()->role_id }}";
        const currentUserId = "{{ Auth::user()->id }}";

        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: 'my-app-key',
            wsHost: '127.0.0.1',
            wsPort: 8080,
            wssPort: 8080,
            forceTLS: false,
            enabledTransports: ['ws', 'wss'],
        });

        window.Echo.channel('laporan-channel')
            .listen('.laporan.masuk', (e) => {
                if (currentUserRoleId == '3' && e.laporan.user_id == currentUserId) return;

                playNotificationSound();
                showMinimalistToast('Laporan Baru Masuk!');
            });

        function playNotificationSound() {
            let audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
            audio.volume = 0.5;
            audio.play().catch(e => console.log('Audio blocked'));
        }

        function showMinimalistToast(msg) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#fff',
                color: '#1f2937',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
            Toast.fire({
                icon: 'info',
                title: msg
            });
        }

        document.querySelectorAll('.btn-unassign').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Batalkan petugas?',
                    text: 'Petugas saat ini akan dilepas dari laporan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Lepas',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) document.getElementById('form-unassign-' + id).submit();
                });
            });
        });

        @if(session('success'))
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: "#059669",
            timer: 3000
        });
        @endif
    </script>

</body>

</html>