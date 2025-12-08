<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Psikolog - Sistem Curhat</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #059669;
            /* Emerald 600 */
            --primary-dark: #047857;
            --primary-light: #d1fae5;
            --text-dark: #1f2937;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            /* Footer Sticky Setup */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            /* Mendorong footer ke bawah */
        }

        /* Hero Section */
        .hero-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            border: none;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px -5px rgba(5, 150, 105, 0.3);
        }

        .hero-pattern {
            position: absolute;
            top: -50%;
            right: -10%;
            font-size: 15rem;
            opacity: 0.1;
            transform: rotate(15deg);
        }

        /* Action Cards */
        .action-card {
            border: none;
            border-radius: 16px;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            height: 100%;
            padding: 2rem;
            position: relative;
            z-index: 1;
            overflow: hidden;
            border-bottom: 3px solid transparent;
        }

        .action-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .card-laporan:hover {
            border-bottom-color: #dc3545;
        }

        .card-chat:hover {
            border-bottom-color: #0d6efd;
        }

        .card-arsip:hover {
            border-bottom-color: #198754;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s;
        }

        .action-card:hover .icon-box {
            transform: scale(1.1);
        }

        /* Insight Card */
        .insight-card {
            background-color: #fff;
            border-left: 5px solid var(--primary-color);
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .btn-rounded {
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- MAIN CONTENT -->
    <main class="py-5">
        <div class="container">

        <div class="container py-4">
        
        {{-- TAMBAHKAN ALERT BATASAN ROLE DI SINI --}}
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <strong>Peringatan!</strong> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Info!</strong> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Content --}}
        @yield('content')
        
    </div>

            <!-- 1. HERO SECTION -->
            <div class="card hero-card mb-5">
                <i class="bi bi-heart-pulse-fill hero-pattern"></i>
                <div class="row align-items-center position-relative z-2">
                    <div class="col-lg-8">
                        <span class="badge bg-white text-success bg-opacity-75 mb-3 px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-patch-check-fill me-1"></i> Psikolog Profesional
                        </span>
                        <h1 class="fw-bold display-6 mb-2">Selamat Datang, {{ Auth::user()->name }}</h1>
                        <p class="mb-0 opacity-90 fs-5 fw-light">
                            Terima kasih telah mendedikasikan waktumu. Ada mahasiswa yang menunggu bimbinganmu hari ini.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <div class="d-inline-block bg-white bg-opacity-20 backdrop-blur rounded-3 p-3 text-center border border-white border-opacity-25">
                            <p class="mb-0 small text-white text-opacity-75">Status Akun</p>
                            <h5 class="mb-0 fw-bold"><i class="bi bi-circle-fill text-warning small me-2"></i>Standby</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. QUICK STATS / REMINDER -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="insight-card p-4 d-flex align-items-start gap-3">
                        <div class="text-success fs-3"><i class="bi bi-lightbulb-fill"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Quote Hari Ini</h6>
                            <p class="text-muted mb-0 fst-italic">
                                "Menjadi pendengar yang baik adalah langkah pertama dalam menyembuhkan luka yang tak terlihat. Semangat melayani!"
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="action-card card-laporan h-100">
                        <div class="d-flex justify-content-between">
                            <div class="icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-inbox-fill"></i>
                            </div>
                            <span class="text-muted small fw-bold">PRIORITAS</span>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Laporan Masuk</h4>
                        <p class="text-muted mb-4">Tinjau keluhan mahasiswa yang membutuhkan penanganan segera.</p>
                        <a href="{{ route('lapor.index') }}" class="btn btn-danger btn-rounded w-100 stretched-link">
                            Buka Laporan <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Live Chat -->
                <div class="col-md-4">
                    <div class="action-card card-chat h-100">
                        <div class="d-flex justify-content-between">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-chat-dots-fill"></i>
                            </div>
                            <span class="text-muted small fw-bold">ONLINE</span>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Ruang Konsultasi</h4>
                        <p class="text-muted mb-4">Akses pesan langsung dan berikan konseling secara real-time.</p>
                        <a href="#" class="btn btn-primary btn-rounded w-100 stretched-link">
                            Mulai Chat <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Arsip -->
                <div class="col-md-4">
                    <div class="action-card card-arsip h-100">
                        <div class="d-flex justify-content-between">
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="bi bi-archive-fill"></i>
                            </div>
                            <span class="text-muted small fw-bold">HISTORY</span>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Arsip Selesai</h4>
                        <p class="text-muted mb-4">Lihat kembali riwayat kasus yang telah berhasil ditangani.</p>
                        <a href="{{ route('lapor.arsip') }}" class="btn btn-success btn-rounded w-100 stretched-link">
                            Lihat Arsip <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>