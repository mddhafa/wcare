<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Curhat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f5f9;
        }

        .navbar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1050;
            background-color: white;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
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
            padding-top: 1.5rem;
        }

        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 2rem;
        }

        .stat-card {
            border: none;
            border-radius: 16px;
            padding: 1.5rem;
            color: white;
            transition: transform 0.2s;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
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

        .bg-gradient-info {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        }

        .stat-icon {
            position: absolute;
            right: 15px;
            bottom: 15px;
            font-size: 3rem;
            opacity: 0.2;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding-top: 2rem;
            }
        }
        
        /* Gaya untuk Toast Container */
        .toast-container {
            z-index: 1090; 
        }
    </style>
</head>

<body>

    <div class="navbar-wrapper">
        @include('components.navbar')
    </div>

    <div class="sidebar d-none d-md-block">
        <div class="list-group list-group-flush px-3">
            <small class="text-muted fw-bold px-3 mb-2 text-uppercase" style="font-size: 0.75rem;">Menu Utama</small>

            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active rounded-3 mb-2 border-0 bg-success">
                <i class="bi bi-grid-fill me-3"></i>Dashboard
            </a>

            <a href="{{ route('admin.mahasiswa') }}" class="list-group-item list-group-item-action rounded-3 mb-2 border-0 text-secondary">
                <i class="bi bi-people-fill me-3"></i>Data Mahasiswa
            </a>
            <a href="{{ route('admin.psikolog') }}" class="list-group-item list-group-item-action rounded-3 mb-2 border-0 text-secondary">
                <i class="bi bi-person-heart me-3"></i>Data Psikolog
            </a>

            <a href="{{ route('lapor.index') }}" class="list-group-item list-group-item-action rounded-3 mb-2 border-0 text-secondary">
                <i class="bi bi-file-earmark-text-fill me-3"></i>Laporan Curhat
            </a>

            <small class="text-muted fw-bold px-3 mb-2 mt-3 text-uppercase" style="font-size: 0.75rem;">Konten</small>

            <a href="{{ route('admin.tambahkontensh') }}" class="list-group-item list-group-item-action rounded-3 mb-2 border-0 text-secondary">
                <i class="bi bi-plus-square-fill me-3"></i>Tambah Self-Healing
            </a>
            <a href="{{ route('halamanselfhealing') }}" class="list-group-item list-group-item-action rounded-3 mb-2 border-0 text-secondary">
                <i class="bi bi-journal-album me-3"></i>Konten Self-Healing
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mt-4 border-top pt-3">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action rounded-3 border-0 text-danger fw-bold">
                    <i class="bi bi-box-arrow-left me-3"></i>Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h3 class="fw-bold text-dark">Ringkasan Sistem</h3>
                <p class="text-muted mb-0">Selamat datang kembali, {{ Auth::user()->name }}! Berikut pantauan hari ini.</p>
            </div>
            <div class="d-none d-md-block">
                <span class="badge bg-white text-dark shadow-sm py-2 px-3 border">
                    📅 {{ date('d F Y') }}
                </span>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card bg-gradient-info">
                    <h2 class="fw-bold mb-1">{{ $stats['total_korban'] }}</h2>
                    <p class="mb-0 fw-medium opacity-75">Pengguna (Korban)</p>
                    <i class="bi bi-people-fill stat-icon"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card bg-gradient-primary">
                    <h2 class="fw-bold mb-1">{{ $stats['total_laporan'] }}</h2>
                    <p class="mb-0 fw-medium opacity-75">Total Laporan</p>
                    <i class="bi bi-archive-fill stat-icon"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card bg-gradient-warning">
                    <h2 class="fw-bold mb-1" id="pending-reports-count">{{ $stats['laporan_pending'] }}</h2>
                    <p class="mb-0 fw-medium opacity-75">Perlu Diproses</p>
                    <i class="bi bi-exclamation-triangle-fill stat-icon"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card bg-gradient-success">
                    <h2 class="fw-bold mb-1">{{ $stats['total_psikolog'] }}</h2>
                    <p class="mb-0 fw-medium opacity-75">Psikolog Terdaftar</p>
                    <i class="bi bi-person-heart stat-icon"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Laporan Terbaru Masuk</h5>
                        <a href="{{ route('lapor.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle text-nowrap">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">Pelapor</th>
                                        <th>Jenis</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Psikolog</th>
                                        <th class="text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($laporan_terbaru as $l)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-2 me-2 text-primary">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                                <span class="fw-medium">{{ $l->korban->name ?? 'Anonim' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $l->jenis }}</td>
                                        <td>{{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}</td>
                                        <td>
                                            @if($l->status == 'pending')
                                            <span class="badge bg-warning text-dark bg-opacity-25 border border-warning">Pending</span>
                                            @elseif($l->status == 'proses')
                                            <span class="badge bg-primary bg-opacity-25 text-primary border border-primary">Proses</span>
                                            @else
                                            <span class="badge bg-success bg-opacity-25 text-success border border-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $l->psikolog->user->name ?? '-' }}</div>
                                        </td>

                                        <td class="text-end pe-4">
                                            <a href="{{ route('lapor.show', $l->id) }}" class="btn btn-sm btn-light text-primary">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada laporan terbaru.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="newReportToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="bi bi-bell-fill me-2"></i>
                    Ada <span id="toast-count"></span> Laporan **BARU** yang Perlu Diproses! 
                    <a href="{{ route('lapor.index') }}" class="text-white text-decoration-underline fw-bold ms-2">Lihat Sekarang</a>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 1. Definisikan variabel kunci
        const toastEl = document.getElementById('newReportToast');
        const toastCountEl = document.getElementById('toast-count');
        const pendingReportsCardCount = document.getElementById('pending-reports-count');

        // Jumlah laporan pending terakhir yang diketahui oleh frontend
        // Mengambil nilai awal dari tampilan stat-card saat halaman dimuat
        let lastKnownPendingCount = parseInt(pendingReportsCardCount.textContent) || 0;

        // Inisialisasi Toast
        const newReportToast = new bootstrap.Toast(toastEl, {
            autohide: false // Biarkan Toast tetap terbuka sampai ditutup pengguna
        });

        // 2. Fungsi untuk menampilkan notifikasi 
        function showNotification(newCount) {
            toastCountEl.textContent = newCount;
            newReportToast.show();
        }

        // 3. Fungsi utama Polling
        function checkNewReports() {
            // !!! Ganti URL ini dengan endpoint API Anda yang sebenarnya di backend Laravel !!!
            // Contoh URL: /api/check-new-reports
            const API_ENDPOINT = '{{ route("api.check-new-reports") }}'; 

            fetch(API_ENDPOINT)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    // Asumsi API mengembalikan JSON seperti: { "pending_count": N }
                    return response.json(); 
                })
                .then(data => {
                    const currentPendingCount = data.pending_count; 

                    // A. Cek apakah ada laporan baru yang masuk (jumlahnya bertambah)
                    if (currentPendingCount > lastKnownPendingCount) {
                        
                        // Tampilkan notifikasi
                        showNotification(currentPendingCount);
                        
                        // Update tampilan kartu dashboard secara dinamis
                        pendingReportsCardCount.textContent = currentPendingCount; 

                    } else if (currentPendingCount <= lastKnownPendingCount) {
                         // Sembunyikan notifikasi jika jumlah laporan berkurang atau tetap nol/sama
                         // Jika operator sudah memprosesnya di halaman lain.
                         newReportToast.hide();
                         pendingReportsCardCount.textContent = currentPendingCount; 
                    }
                    
                    // B. Update jumlah terakhir yang diketahui
                    lastKnownPendingCount = currentPendingCount;

                })
                .catch(error => {
                    console.error('Error saat mengambil laporan baru:', error);
                })
                .finally(() => {
                    // C. Jadwal Polling berikutnya setelah 10 detik
                    setTimeout(checkNewReports, 10000); // Polling setiap 10 detik (10000 ms)
                });
        }

        // 4. Inisialisasi: Cek status saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', function() {
            if (lastKnownPendingCount > 0) {
                // Tampilkan notifikasi awal jika ada laporan pending saat load
                showNotification(lastKnownPendingCount);
            }
            // Mulai Polling untuk Real-Time Update
            // Mulai 5 detik setelah load untuk memberi waktu inisialisasi
            setTimeout(checkNewReports, 5000); 
        });
    </script>
</body>

</html>