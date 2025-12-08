<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sistem Curhat</title>

  <!-- Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary-color: #059669;
      /* Emerald 600 */
      --primary-dark: #047857;
      --primary-light: #d1fae5;
      --text-dark: #1f2937;
      --bg-light: #f9fafb;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--bg-light);
      color: var(--text-dark);
      overflow-x: hidden;
    }

    /* Banner & Hero */
    .banner-img {
      height: 320px;
      object-fit: cover;
      border-radius: 20px;
    }

    .carousel-inner {
      border-radius: 20px;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .hero-section {
      background-color: #ffffff;
      border-bottom: 1px solid #e5e7eb;
      padding-bottom: 3rem;
    }

    /* Feature Cards */
    .feature-card {
      border: none;
      border-radius: 16px;
      background: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
      height: 100%;
      padding: 2rem 1.5rem;
      position: relative;
      z-index: 1;
      overflow: hidden;
    }

    .feature-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      w-100;
      h-100;
      background: var(--primary-color);
      width: 100%;
      height: 0%;
      z-index: -1;
      transition: all 0.3s ease;
      opacity: 0.05;
    }

    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
      border-bottom: 4px solid var(--primary-color);
    }

    .feature-card:hover::before {
      height: 100%;
    }

    .icon-wrapper {
      width: 64px;
      height: 64px;
      background-color: var(--primary-light);
      color: var(--primary-color);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 1.75rem;
      transition: all 0.3s;
    }

    .feature-card:hover .icon-wrapper {
      background-color: var(--primary-color);
      color: white;
      transform: rotateY(180deg);
    }

    /* Psikolog Cards */
    .psikolog-card {
      border: none;
      border-radius: 20px;
      background: white;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s;
    }

    .psikolog-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .psikolog-img-wrapper {
      height: 220px;
      overflow: hidden;
      position: relative;
    }

    .psikolog-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
    }

    .psikolog-card:hover .psikolog-img {
      transform: scale(1.05);
    }

    .status-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: rgba(255, 255, 255, 0.9);
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--primary-color);
      backdrop-filter: blur(4px);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Buttons */
    .btn-custom-primary {
      background-color: var(--primary-color);
      color: white;
      border-radius: 50px;
      padding: 10px 28px;
      font-weight: 600;
      border: none;
      box-shadow: 0 4px 14px 0 rgba(5, 150, 105, 0.39);
      transition: all 0.2s;
    }

    .btn-custom-primary:hover {
      background-color: var(--primary-dark);
      color: white;
      transform: translateY(-2px);
    }

    .btn-custom-outline {
      background-color: transparent;
      color: var(--primary-color);
      border: 2px solid var(--primary-color);
      border-radius: 50px;
      padding: 8px 24px;
      font-weight: 600;
      transition: all 0.2s;
    }

    .btn-custom-outline:hover {
      background-color: var(--primary-color);
      color: white;
    }

    /* Emotion Modal */
    input[type="radio"]:checked+.emosi-card {
      background-color: var(--primary-light);
      border: 2px solid var(--primary-color);
      color: var(--primary-dark);
      transform: scale(1.05);
    }

    .emosi-card {
      cursor: pointer;
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      padding: 1.5rem;
      transition: all 0.2s;
    }

    .emosi-card:hover {
      border-color: var(--primary-color);
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  @include('components.navbar')

  <!-- 1. HERO SECTION -->
  <section class="hero-section pt-5">
    <div class="container">
      <div class="row align-items-center">
        <!-- Text Side -->
        <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5">
          <div class="d-inline-block px-3 py-1 mb-3 text-xs font-semibold tracking-wider text-success text-uppercase bg-green-100 rounded-full">
            👋 Welcome back
          </div>
          <h1 class="display-5 fw-bold mb-3 lh-sm text-dark">
            Kesehatan Mentalmu <br> Adalah <span style="color: var(--primary-color);">Prioritas Kami</span>
          </h1>
          <p class="lead text-muted mb-4">
            Jangan biarkan beban pikiran mengganggumu. Kami menyediakan ruang aman untuk bercerita, berkonsultasi, dan memulihkan diri.
          </p>

          <div class="d-flex flex-wrap gap-3">
            <button class="btn btn-custom-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalEmosi">
              <i class="bi bi-emoji-smile me-2"></i> Cek Mood Hari Ini
            </button>
            <a href="{{ route('lapor.create') }}" class="btn btn-custom-outline btn-lg">
              <i class="bi bi-pencil-square me-2"></i> Buat Laporan
            </a>
          </div>
        </div>

        <!-- Carousel Side -->
        <div class="col-lg-6">
          <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
              <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
              <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="{{ asset('images/banner2.png') }}" class="d-block w-100 banner-img shadow" alt="Banner 1">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('images/banner2.png') }}" class="d-block w-100 banner-img shadow" alt="Banner 2">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('images/banner2.png') }}" class="d-block w-100 banner-img shadow" alt="Banner 3">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MODAL PILIH EMOSI -->
  <form action="{{ route('emosi.pilih') }}" method="POST">
    @csrf
    <div class="modal fade" id="modalEmosi" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
          <div class="modal-header border-0 pb-0 ps-4 pt-4">
            <h5 class="modal-title fw-bold">Apa yang kamu rasakan sekarang?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <div class="row g-3">
              <div class="col-6 col-md-3">
                <label class="w-100">
                  <input type="radio" name="emosi_id" value="1" class="d-none">
                  <div class="emosi-card text-center">
                    <div class="display-4 mb-2">😊</div>
                    <div class="fw-bold">Senang</div>
                  </div>
                </label>
              </div>
              <div class="col-6 col-md-3">
                <label class="w-100">
                  <input type="radio" name="emosi_id" value="3" class="d-none">
                  <div class="emosi-card text-center">
                    <div class="display-4 mb-2">😢</div>
                    <div class="fw-bold">Sedih</div>
                  </div>
                </label>
              </div>
              <div class="col-6 col-md-3">
                <label class="w-100">
                  <input type="radio" name="emosi_id" value="2" class="d-none">
                  <div class="emosi-card text-center">
                    <div class="display-4 mb-2">😡</div>
                    <div class="fw-bold">Marah</div>
                  </div>
                </label>
              </div>
              <div class="col-6 col-md-3">
                <label class="w-100">
                  <input type="radio" name="emosi_id" value="4" class="d-none">
                  <div class="emosi-card text-center">
                    <div class="display-4 mb-2">😨</div>
                    <div class="fw-bold">Takut</div>
                  </div>
                </label>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pe-4 pb-4">
            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-custom-primary">Simpan Mood</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- 2. LAYANAN SECTION -->
  <section class="py-5">
    <div class="container py-4">
      <div class="text-center mb-5">
        <h6 class="text-success fw-bold text-uppercase ls-1">Fitur Unggulan</h6>
        <h2 class="fw-bold">Apa yang Bisa Kamu Lakukan?</h2>
      </div>

      <div class="row g-4">
        <!-- Chatbot -->
        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="icon-wrapper"><i class="bi bi-robot"></i></div>
            <h5 class="fw-bold mb-2">AI Chatbot</h5>
            <p class="text-muted small mb-4">Teman curhat virtual yang siap mendengarkanmu kapan saja tanpa menghakimi.</p>
            <a href="{{ url('/chatbot') }}" class="btn btn-custom-outline btn-sm w-100 stretched-link">Mulai Chat</a>
          </div>
        </div>

        <!-- Konsultasi -->
        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="icon-wrapper"><i class="bi bi-person-heart"></i></div>
            <h5 class="fw-bold mb-2">Konseling Ahli</h5>
            <p class="text-muted small mb-4">Terhubung langsung dengan psikolog profesional untuk penanganan lebih lanjut.</p>
            <a href="#" class="btn btn-custom-outline btn-sm w-100 stretched-link">Hubungi</a>
          </div>
        </div>

        <!-- Lapor -->
        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="icon-wrapper"><i class="bi bi-shield-exclamation"></i></div>
            <h5 class="fw-bold mb-2">Lapor Masalah</h5>
            <p class="text-muted small mb-4">Laporkan tindak bullying atau kekerasan seksual di lingkungan kampus secara aman.</p>
            <a href="{{ route('lapor.create') }}" class="btn btn-custom-outline btn-sm w-100 stretched-link">Buat Laporan</a>
          </div>
        </div>

        <!-- Self Healing -->
        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="icon-wrapper"><i class="bi bi-journal-album"></i></div>
            <h5 class="fw-bold mb-2">Self Healing</h5>
            <p class="text-muted small mb-4">Konten video dan artikel relaksasi yang dikurasi khusus untuk mood kamu.</p>
            <a href="{{ url('/selfhealing') }}" class="btn btn-custom-outline btn-sm w-100 stretched-link">Jelajahi</a>
          </div>
        </div>
      </div>

      <div class="text-center mt-4">
        <a href="{{ route('lapor.index') }}" class="text-decoration-none text-muted small fw-medium">
          <i class="bi bi-clock-history me-1"></i> Lihat riwayat laporan saya
        </a>
      </div>
    </div>
  </section>

  <!-- 3. TENTANG KAMI -->
  <section class="py-5 bg-white border-top">
    <div class="container py-3">
      <div class="row align-items-center">
        <div class="col-lg-5 mb-4 mb-lg-0">
          <img src="{{ asset('images/banner1.png') }}" alt="About" class="img-fluid rounded-4 shadow-lg w-100">
        </div>
        <div class="col-lg-7 ps-lg-5">
          <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">Tentang UMY Curhat</span>
          <h2 class="fw-bold mb-3" style="color: var(--text-dark);">Ruang Aman Bagi Mahasiswa</h2>
          <p class="text-muted lead fs-6 mb-4">
            Kami hadir sebagai jembatan bagi mahasiswa Universitas Muhammadiyah Yogyakarta untuk mendapatkan dukungan mental yang layak, mudah diakses, dan terpercaya.
          </p>
          <div class="row g-3">
            <div class="col-sm-6">
              <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                <span class="fw-medium">100% Rahasia & Aman</span>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill text-success fs-4 me-3"></i>
                <span class="fw-medium">Psikolog Tersertifikasi</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. TIM PSIKOLOG (DINAMIS) -->
  <section class="py-5" style="background-color: #f3f4f6;">
    <div class="container py-4">
      <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
          <h6 class="text-success fw-bold text-uppercase ls-1">Tim Ahli</h6>
          <h2 class="fw-bold">Psikolog Profesional</h2>
        </div>
        <!-- Tombol Lihat Semua (Opsional) -->
        <!-- <a href="#" class="btn btn-outline-dark rounded-pill">Lihat Semua</a> -->
      </div>

      <!-- LOGIKA PHP: Mengambil data Psikolog langsung dari DB -->
      @php
      // Mengambil 4 user dengan role_id 2 (Psikolog) terbaru
      $team_psikolog = \App\Models\User::where('role_id', 2)->with('psikolog')->latest()->take(4)->get();
      @endphp

      <div class="row g-4">
        @forelse($team_psikolog as $psi)
        <div class="col-md-6 col-lg-3">
          <div class="psikolog-card h-100">
            <div class="psikolog-img-wrapper">
              <!-- Cek Foto: Jika ada pakai storage, jika tidak pakai inisial/default -->
              @if($psi->avatar && $psi->avatar != 'avatar.png')
              <img src="{{ asset('storage/' . $psi->avatar) }}" alt="{{ $psi->name }}" class="psikolog-img">
              @else
              <!-- Placeholder Image Generator jika tidak ada foto -->
              <img src="https://ui-avatars.com/api/?name={{ urlencode($psi->name) }}&background=059669&color=fff&size=512" alt="{{ $psi->name }}" class="psikolog-img">
              @endif

              <div class="status-badge">
                <i class="bi bi-circle-fill text-success small me-1"></i> Available
              </div>
            </div>
            <div class="card-body p-4 text-center">
              <h5 class="fw-bold text-dark mb-1">{{ $psi->name }}</h5>
              <p class="text-muted small mb-3">Psikolog Klinis</p>

              <!-- Jadwal (jika ada data relasi) -->
              @if($psi->psikolog && $psi->psikolog->jadwal_tersedia)
              <div class="badge bg-light text-dark border mb-3">
                <i class="bi bi-clock me-1"></i>
                {{ \Carbon\Carbon::parse($psi->psikolog->jadwal_tersedia)->format('d M, H:i') }}
              </div>
              @else
              <div class="badge bg-light text-muted border mb-3">
                <i class="bi bi-calendar-x me-1"></i> Jadwal belum diatur
              </div>
              @endif

              <div class="d-grid">
                <button class="btn btn-sm btn-outline-success rounded-pill">Buat Janji</button>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
          <p class="text-muted">Belum ada data psikolog yang ditampilkan.</p>
        </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  @include('components.footer')

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @if(session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session('
      success ') }}',
      confirmButtonColor: '#059669',
      timer: 3000
    });
  </script>
  @endif

</body>

</html>