<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Curhat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }

        .navbar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1050;
            background-color: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            height: 70px;
        }

        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            height: calc(100vh - 70px);
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
            z-index: 1040;
            overflow-y: auto;
            padding: 1.5rem 1rem;
        }

        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }

        .menu-title {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 1.5rem 0 0.8rem 0.5rem;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            margin-bottom: 0.4rem;
            border-radius: 12px;
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .nav-link-custom:hover {
            background-color: #f1f5f9;
            color: #059669;
            border-color: #e2e8f0;
            transform: translateX(5px);
        }

        .nav-link-custom.active {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border-color: #059669;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
        }

        .nav-link-custom i {
            width: 24px;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .stat-card {
            border: none;
            border-radius: 18px;
            padding: 1.8rem;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-icon {
            position: absolute;
            right: 20px;
            bottom: 20px;
            font-size: 3.5rem;
            opacity: 0.25;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.95rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .dashboard-header {
            background: white;
            border-radius: 16px;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .date-badge {
            background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
            border: 1px solid #e2e8f0;
            padding: 0.7rem 1.3rem;
            border-radius: 12px;
            font-weight: 600;
            color: #475569;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .reports-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .card-header-custom {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-custom thead {
            background-color: #f8fafc;
        }

        .table-custom th {
            font-weight: 600;
            color: #475569;
            padding: 1.2rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-custom td {
            padding: 1.2rem 2rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 500;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }

        .user-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0ea5e9 0%, #4f46e5 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .user-avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .badge-status {
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid;
        }

        .badge-pending {
            background: rgba(245, 158, 11, 0.15);
            color: #d97706;
            border-color: rgba(245, 158, 11, 0.3);
        }

        .badge-proses {
            background: rgba(79, 70, 229, 0.15);
            color: #4f46e5;
            border-color: rgba(79, 70, 229, 0.3);
        }

        .badge-selesai {
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
            border-color: rgba(16, 185, 129, 0.3);
        }

        .btn-view {
            padding: 0.5rem 1.2rem;
            background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
            border: 1px solid #e2e8f0;
            color: #475569;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(5, 150, 105, 0.2);
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .dashboard-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }

        .logout-btn {
            margin-top: 2rem;
            padding: 0.85rem 1rem;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
            text-align: left;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            transform: translateX(5px);
        }
    </style>
</head>

<body>

    <div class="navbar-wrapper">
        @include('components.navbar')
    </div>

    <div class="sidebar d-none d-md-block">
        <div class="menu-title">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link-custom active">
            <i class="bi bi-grid-fill"></i>Dashboard
        </a>
        <a href="{{ route('admin.mahasiswa') }}" class="nav-link-custom">
            <i class="bi bi-people-fill"></i>Data Mahasiswa
        </a>
        <a href="{{ route('admin.psikolog') }}" class="nav-link-custom">
            <i class="bi bi-person-heart"></i>Data Psikolog
        </a>
        <a href="{{ route('lapor.index') }}" class="nav-link-custom">
            <i class="bi bi-file-earmark-text-fill"></i>Laporan Curhat
        </a>

        <div class="menu-title">Konten</div>
        <a href="{{ route('admin.tambahkontensh') }}" class="nav-link-custom">
            <i class="bi bi-plus-square-fill"></i>Tambah Self-Healing
        </a>
        <a href="{{ route('halamanselfhealing') }}" class="nav-link-custom">
            <i class="bi bi-journal-album"></i>Konten Self-Healing
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left me-2"></i>Logout
            </button>
        </form>
    </div>

    <div class="main-content">
        <div class="dashboard-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold text-dark mb-2">Ringkasan Sistem</h3>
                <p class="text-muted mb-0">Selamat datang kembali, {{ Auth::user()->name }}!</p>
            </div>
            <div class="date-badge">
                <i class="bi bi-calendar3 me-2"></i>{{ date('d F Y') }}
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card bg-gradient-info">
                    <div class="stat-number">{{ $stats['total_korban'] }}</div>
                    <div class="stat-label">Pengguna (Mahasiswa)</div>
                    <i class="bi bi-people-fill stat-icon"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-gradient-primary">
                    <div class="stat-number" id="statTotalLaporan">{{ $stats['total_laporan'] }}</div>
                    <div class="stat-label">Total Laporan</div>
                    <i class="bi bi-archive-fill stat-icon"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-gradient-warning">
                    <div class="stat-number" id="statPending">{{ $stats['laporan_pending'] }}</div>
                    <div class="stat-label">Perlu Diproses</div>
                    <i class="bi bi-exclamation-triangle-fill stat-icon"></i>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-gradient-success">
                    <div class="stat-number">{{ $stats['total_psikolog'] }}</div>
                    <div class="stat-label">Psikolog Terdaftar</div>
                    <i class="bi bi-person-heart stat-icon"></i>
                </div>
            </div>
        </div>

        <div class="reports-card">
            <div class="card-header-custom">
                <h5 class="fw-bold mb-0">Laporan Terbaru Masuk</h5>
                <a href="{{ route('lapor.index') }}" class="btn-view">
                    <i class="bi bi-arrow-right me-2"></i>Lihat Semua
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom" id="recentTable">
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Psikolog</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan_terbaru as $l)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @php $user = $l->korban; @endphp
                                    @if($user && $user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="user-avatar-img">
                                    @elseif($user && $user->korban && $user->korban->foto && file_exists(public_path('uploads/' . $user->korban->foto)))
                                    <img src="{{ asset('uploads/' . $user->korban->foto) }}" alt="{{ $user->name }}" class="user-avatar-img">
                                    @else
                                    <div class="user-avatar-small">
                                        {{ strtoupper(substr($l->korban->name ?? 'A', 0, 1)) }}
                                    </div>
                                    @endif

                                    <span class="fw-medium">{{ $l->korban->name ?? 'Anonim' }}</span>
                                </div>
                            </td>
                            <td>{{ $l->jenis }}</td>
                            <td>{{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}</td>
                            <td>
                                @if($l->status == 'pending')
                                <span class="badge-status badge-pending">Pending</span>
                                @elseif($l->status == 'proses')
                                <span class="badge-status badge-proses">Proses</span>
                                @else
                                <span class="badge-status badge-selesai">Selesai</span>
                                @endif
                            </td>
                            <td>{{ $l->psikolog->user->name ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('lapor.show', $l->id) }}" class="btn-view">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr id="noDataRow">
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox display-6 mb-3"></i>
                                    <p class="mb-0">Belum ada laporan terbaru</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <script>
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
                let laporan = e.laporan;

                playNotificationSound();
                showMinimalistToast();

                updateStats();

                addNewRowToDashboard(laporan);
            });

        function playNotificationSound() {
            let audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
            audio.volume = 0.5;
            audio.play().catch(error => console.log('Audio dicegah browser.'));
        }

        function showMinimalistToast() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#1f2937',
                customClass: {
                    popup: 'rounded-pill shadow-lg border-0 px-4 py-2 mt-3 me-3 animate__animated animate__fadeInRight',
                    title: 'fs-6 fw-bold mb-0',
                    timerProgressBar: 'bg-success'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            Toast.fire({
                icon: 'success',
                iconColor: '#10b981',
                title: 'Laporan Baru Masuk!'
            });
        }

        function updateStats() {
            let totalEl = document.getElementById('statTotalLaporan');
            let pendingEl = document.getElementById('statPending');

            if (totalEl) {
                let val = parseInt(totalEl.innerText);
                totalEl.innerText = val + 1;
                totalEl.parentElement.classList.add('animate__animated', 'animate__pulse');
            }
            if (pendingEl) {
                let val = parseInt(pendingEl.innerText);
                pendingEl.innerText = val + 1;
            }
        }

        function addNewRowToDashboard(data) {
            let noDataRow = document.getElementById('noDataRow');
            if (noDataRow) noDataRow.remove();

            let dateObj = new Date(data.tanggal);
            let dateStr = dateObj.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

            let namaPelapor = data.korban ? data.korban.name : 'Anonim';
            let profileContent = '';

            let avatarPath = data.korban ? data.korban.avatar : null;
            let fotoKorbanPath = (data.korban && data.korban.korban) ? data.korban.korban.foto : null;

            if (avatarPath) {
                let url = avatarPath.startsWith('http') ? avatarPath : `/storage/${avatarPath}`;
                profileContent = `<img src="${url}" alt="${namaPelapor}" class="user-avatar-img">`;
            } else if (fotoKorbanPath) {
                let url = `/uploads/${fotoKorbanPath}`;
                profileContent = `<img src="${url}" alt="${namaPelapor}" class="user-avatar-img">`;
            } else {
                let inisial = namaPelapor.charAt(0).toUpperCase();
                profileContent = `<div class="user-avatar-small">${inisial}</div>`;
            }

            let rowHtml = `
            <tr class="animate__animated animate__fadeInDown" style="background-color: #f0fdf4;">
                <td>
                    <div class="d-flex align-items-center gap-3">
                        ${profileContent}
                        <span class="fw-medium">${namaPelapor}</span>
                    </div>
                </td>
                <td>${data.jenis}</td>
                <td>${dateStr}</td>
                <td><span class="badge-status badge-pending">Pending</span></td>
                <td>-</td>
                <td class="text-end">
                    <a href="/lapor/${data.id}" class="btn-view">
                        <i class="bi bi-eye me-1"></i>Detail
                    </a>
                </td>
            </tr>`;

            let tbody = document.querySelector('#recentTable tbody');
            if (tbody) {
                tbody.insertAdjacentHTML('afterbegin', rowHtml);

                if (tbody.children.length > 5) {
                    tbody.lastElementChild.remove();
                }
            }
        }
    </script>
</body>

</html>