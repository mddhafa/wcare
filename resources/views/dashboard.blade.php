<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sistem Curhat</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --primary-color: #059669;
      --primary-dark: #047857;
      --primary-light: #d1fae5;
      --text-dark: #1f2937;
      --bg-light: #f9fafb;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--bg-light);
      color: var(--text-dark);
    }

    .hero-section {
      padding: 4rem 0 3rem;
      background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
    }

    .hero-title {
      font-size: 3.2rem;
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 1.5rem;
      background: linear-gradient(135deg, #1f2937 0%, var(--primary-color) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
      font-size: 1.2rem;
      color: #64748b;
      margin-bottom: 2.5rem;
      line-height: 1.7;
    }

    .hero-banner {
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(5, 150, 105, 0.1);
      height: 380px;
      position: relative;
    }

    .hero-banner img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .hero-banner:hover img {
      transform: scale(1.05);
    }

    .btn-hero-primary {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      color: white;
      border: none;
      padding: 1rem 2.5rem;
      border-radius: 12px;
      font-weight: 600;
      font-size: 1.1rem;
      box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    .btn-hero-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 25px rgba(5, 150, 105, 0.4);
      color: white;
    }

    .btn-hero-secondary {
      background: white;
      color: var(--primary-color);
      border: 2px solid var(--primary-color);
      padding: 1rem 2.5rem;
      border-radius: 12px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    .btn-hero-secondary:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-3px);
    }

    .features-section {
      padding: 5rem 0;
      background: white;
    }

    .section-title {
      font-size: 2.8rem;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 1rem;
      text-align: center;
    }

    .section-subtitle {
      color: #64748b;
      font-size: 1.1rem;
      text-align: center;
      margin-bottom: 4rem;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .feature-card {
      background: white;
      border-radius: 20px;
      padding: 2.5rem 2rem;
      height: 100%;
      border: 1px solid #e2e8f0;
      transition: all 0.4s ease;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
      border-color: var(--primary-color);
    }

    .feature-icon {
      width: 80px;
      height: 80px;
      border-radius: 20px;
      background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 2rem;
      font-size: 2rem;
      color: var(--primary-color);
      border: 1px solid #e2e8f0;
      transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      color: white;
      transform: rotate(5deg) scale(1.1);
    }

    .feature-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 1rem;
    }

    .feature-description {
      color: #64748b;
      line-height: 1.6;
      margin-bottom: 2rem;
      flex-grow: 1;
    }

    .feature-button-container {
      margin-top: auto;
      min-height: 48px;
    }

    .feature-button {
      background: white;
      color: var(--primary-color);
      border: 2px solid var(--primary-color);
      border-radius: 10px;
      padding: 0.8rem 1.5rem;
      font-weight: 600;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      text-decoration: none;
    }

    .feature-button:hover {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(5, 150, 105, 0.2);
    }

    .about-section {
      padding: 5rem 0;
      background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    }

    .about-image {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      height: 400px;
    }

    .about-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .about-badge {
      background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
      color: #92400e;
      padding: 0.6rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.9rem;
      display: inline-block;
      margin-bottom: 1.5rem;
    }

    .about-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 1.5rem;
      line-height: 1.2;
    }

    .about-text {
      font-size: 1.1rem;
      color: #64748b;
      line-height: 1.7;
      margin-bottom: 2rem;
    }

    .benefit-item {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .benefit-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: var(--primary-light);
      color: var(--primary-color);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .psychologists-section {
      padding: 5rem 0;
      background: white;
    }

    .psychologist-card {
      background: white;
      border-radius: 20px;
      overflow: hidden;
      border: 1px solid #e2e8f0;
      transition: all 0.3s ease;
      height: 100%;
    }

    .psychologist-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .psychologist-header {
      height: 120px;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      position: relative;
    }

    .psychologist-avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 5px solid white;
      position: absolute;
      bottom: -50px;
      left: 50%;
      transform: translateX(-50%);
      overflow: hidden;
      background: white;
    }

    .psychologist-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .psychologist-avatar-text {
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      font-weight: 700;
    }

    .psychologist-body {
      padding: 4rem 2rem 2rem;
      text-align: center;
    }

    .psychologist-name {
      font-size: 1.4rem;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 0.5rem;
    }

    .psychologist-role {
      color: var(--primary-color);
      font-weight: 600;
      margin-bottom: 1.5rem;
    }

    .psychologist-schedule {
      background: #f8fafc;
      border-radius: 12px;
      padding: 1rem;
      margin-top: 1rem;
      border: 1px solid #e2e8f0;
    }

    .status-badge {
      position: absolute;
      top: 20px;
      right: 20px;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: 600;
      z-index: 2;
    }

    .status-online {
      background: #dcfce7;
      color: #166534;
    }

    .status-offline {
      background: #f1f5f9;
      color: #64748b;
    }

    .modal-emosi .modal-content {
      border-radius: 20px;
      border: none;
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }

    .emosi-option {
      border: 2px solid #e2e8f0;
      border-radius: 16px;
      padding: 2rem 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
      text-align: center;
      position: relative;
    }

    .emosi-option:hover {
      border-color: var(--primary-color);
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .emosi-option.selected {
      border-color: var(--primary-color);
      background: var(--primary-light);
      transform: scale(1.05);
      box-shadow: 0 10px 25px rgba(5, 150, 105, 0.15);
    }

    .emosi-option input:checked+.emosi-content {
      border-color: var(--primary-color);
      background: var(--primary-light);
      transform: scale(1.05);
      box-shadow: 0 10px 25px rgba(5, 150, 105, 0.15);
    }

    .selected-indicator {
      position: absolute;
      top: 10px;
      right: 10px;
      width: 24px;
      height: 24px;
      background: var(--primary-color);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      opacity: 0;
      transform: scale(0);
      transition: all 0.3s ease;
    }

    .emosi-option.selected .selected-indicator {
      opacity: 1;
      transform: scale(1);
    }

    .emosi-icon {
      font-size: 3.5rem;
      margin-bottom: 1rem;
      display: block;
      transition: transform 0.3s ease;
    }

    .emosi-option.selected .emosi-icon {
      transform: scale(1.1);
    }

    .emosi-label {
      font-weight: 600;
      font-size: 1.1rem;
      color: #374151;
      transition: color 0.3s ease;
    }

    .emosi-option.selected .emosi-label {
      color: var(--primary-dark);
      font-weight: 700;
    }

    .selected-message {
      text-align: center;
      margin-top: 1rem;
      color: var(--primary-color);
      font-weight: 600;
      font-size: 0.9rem;
      opacity: 0;
      transform: translateY(10px);
      transition: all 0.3s ease;
    }

    .emosi-option.selected .selected-message {
      opacity: 1;
      transform: translateY(0);
    }

    @media (max-width: 768px) {
      .hero-title {
        font-size: 2.5rem;
      }

      .section-title {
        font-size: 2.2rem;
      }

      .hero-banner {
        height: 280px;
        margin-top: 2rem;
      }

      .btn-hero-primary,
      .btn-hero-secondary {
        padding: 0.8rem 2rem;
        font-size: 1rem;
        width: 100%;
        justify-content: center;
        margin-bottom: 1rem;
      }

      .feature-button-container {
        min-height: 44px;
      }
    }
  </style>
</head>

<body>

  @include('components.navbar')

  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="hero-title">Kesehatan Mentalmu<br>Adalah Prioritas Kami</h1>
          <p class="hero-subtitle">Jangan biarkan beban pikiran mengganggumu. Kami menyediakan ruang aman untuk bercerita, berkonsultasi, dan memulihkan diri dengan dukungan profesional.</p>

          <div class="d-flex flex-wrap gap-3">
            <button class="btn-hero-primary" data-bs-toggle="modal" data-bs-target="#modalEmosi">
              <i class="bi bi-emoji-smile"></i>
              Cek Mood Hari Ini
            </button>
            <a href="{{ route('lapor.create') }}" class="btn-hero-secondary">
              <i class="bi bi-pencil-square"></i>
              Buat Laporan
            </a>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="hero-banner">
            <img src="{{ asset('images/banner2.png') }}" alt="Mental Health Support">
          </div>
        </div>
      </div>
    </div>
  </section>

  <form action="{{ route('emosi.pilih') }}" method="POST">
    @csrf
    <div class="modal fade modal-emosi" id="modalEmosi" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-0 pb-0">
            <div class="w-100 text-center">
              <h5 class="modal-title fw-bold fs-4">Bagaimana perasaanmu hari ini?</h5>
              <p class="text-muted mb-0">Pilih emosi yang paling menggambarkan kondisi saat ini</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body p-4">
            <div class="row g-3">
              <div class="col-6 col-md-3">
                <label class="w-100 emosi-option" data-value="1">
                  <input type="radio" name="emosi_id" value="1" class="d-none">
                  <div class="emosi-content">
                    <div class="selected-indicator">
                      <i class="bi bi-check"></i>
                    </div>
                    <span class="emosi-icon">😊</span>
                    <div class="emosi-label">Senang</div>
                    <div class="selected-message">Dipilih</div>
                  </div>
                </label>
              </div>
              <div class="col-6 col-md-3">
                <label class="w-100 emosi-option" data-value="3">
                  <input type="radio" name="emosi_id" value="3" class="d-none">
                  <div class="emosi-content">
                    <div class="selected-indicator">
                      <i class="bi bi-check"></i>
                    </div>
                    <span class="emosi-icon">😢</span>
                    <div class="emosi-label">Sedih</div>
                    <div class="selected-message">Dipilih</div>
                  </div>
                </label>
              </div>
              <div class="col-6 col-md-3">
                <label class="w-100 emosi-option" data-value="2">
                  <input type="radio" name="emosi_id" value="2" class="d-none">
                  <div class="emosi-content">
                    <div class="selected-indicator">
                      <i class="bi bi-check"></i>
                    </div>
                    <span class="emosi-icon">😡</span>
                    <div class="emosi-label">Marah</div>
                    <div class="selected-message">Dipilih</div>
                  </div>
                </label>
              </div>
              <div class="col-6 col-md-3">
                <label class="w-100 emosi-option" data-value="4">
                  <input type="radio" name="emosi_id" value="4" class="d-none">
                  <div class="emosi-content">
                    <div class="selected-indicator">
                      <i class="bi bi-check"></i>
                    </div>
                    <span class="emosi-icon">😨</span>
                    <div class="emosi-label">Takut</div>
                    <div class="selected-message">Dipilih</div>
                  </div>
                </label>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Nanti Saja</button>
            <button type="submit" class="btn-hero-primary px-4" id="submitMoodBtn" disabled>
              Simpan Mood
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <section class="features-section">
    <div class="container">
      <h2 class="section-title">Apa yang Bisa Kamu Lakukan?</h2>
      <p class="section-subtitle">Berbagai layanan yang tersedia untuk mendukung kesehatan mentalmu</p>

      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-robot"></i>
            </div>
            <h4 class="feature-title">AI Chatbot</h4>
            <p class="feature-description">Teman curhat virtual yang siap mendengarkanmu kapan saja tanpa menghakimi.</p>
            <div class="feature-button-container">
              <a href="{{ url('/chatbot') }}" class="feature-button">
                <i class="bi bi-chat-left"></i>
                Mulai Chat
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-person-heart"></i>
            </div>
            <h4 class="feature-title">Konseling Ahli</h4>
            <p class="feature-description">Terhubung langsung dengan psikolog profesional untuk penanganan lebih lanjut.</p>
            <div class="feature-button-container">
              <a href="{{ route('homechat') }}" class="feature-button">
                <i class="bi bi-telephone"></i>
                Hubungi
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-shield-exclamation"></i>
            </div>
            <h4 class="feature-title">Lapor Masalah</h4>
            <p class="feature-description">Laporkan tindak bullying atau kekerasan seksual di lingkungan kampus secara aman.</p>
            <div class="feature-button-container">
              <a href="{{ route('lapor.create') }}" class="feature-button">
                <i class="bi bi-pencil-square"></i>
                Buat Laporan
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="bi bi-journal-album"></i>
            </div>
            <h4 class="feature-title">Self Healing</h4>
            <p class="feature-description">Konten video dan artikel relaksasi yang dikurasi khusus untuk mood kamu.</p>
            <div class="feature-button-container">
              <a href="{{ url('/selfhealing') }}" class="feature-button">
                <i class="bi bi-search"></i>
                Jelajahi
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="about-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="about-image">
            <img src="{{ asset('images/banner1.png') }}" alt="Tentang Kami">
          </div>
        </div>
        <div class="col-lg-6 ps-lg-5">
          <span class="about-badge">Tentang Wcare</span>
          <h2 class="about-title">Ruang Aman Bagi Mahasiswa</h2>
          <p class="about-text">Kami hadir sebagai jembatan bagi mahasiswa Universitas Muhammadiyah Yogyakarta untuk mendapatkan dukungan mental yang layak, mudah diakses, dan terpercaya.</p>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="benefit-item">
                <div class="benefit-icon">
                  <i class="bi bi-shield-check"></i>
                </div>
                <span class="fw-medium">100% Rahasia & Aman</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="benefit-item">
                <div class="benefit-icon">
                  <i class="bi bi-award"></i>
                </div>
                <span class="fw-medium">Psikolog Tersertifikasi</span>
              </div>
            </div>
          </div>

          <div class="mt-4">
            <a href="{{ route('lapor.index') }}" class="feature-button d-inline-flex" style="width: auto; padding: 0.6rem 1.2rem;">
              <i class="bi bi-clock-history me-1"></i> Lihat riwayat laporan saya
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="psychologists-section">
    <div class="container">
      <div class="row mb-5">
        <div class="col-12 text-center">
          <h2 class="section-title">Tim Psikolog Profesional</h2>
          <p class="section-subtitle">Bertemu dengan ahli yang siap membantu perjalanan kesehatan mentalmu</p>
        </div>
      </div>

      <div class="row g-4">
        @php
        $team_psikolog = \App\Models\User::where('role_id', 2)
        ->with('psikolog')
        ->whereHas('psikolog', function($q) {
        $q->whereNotNull('jam_mulai')->whereNotNull('jam_selesai');
        })
        ->latest()
        ->take(4)
        ->get();
        @endphp

        @forelse($team_psikolog as $psi)
        <div class="col-md-6 col-lg-3">
          <div class="psychologist-card">
            <div class="psychologist-header">
              <div class="status-badge {{ $psi->active_status == 1 ? 'status-online' : 'status-offline' }}">
                <i class="bi bi-circle-fill small me-1"></i>
                {{ $psi->active_status == 1 ? 'Online' : 'Offline' }}
              </div>

              <div class="psychologist-avatar">
                @if($psi->avatar && $psi->avatar != 'avatar.png')
                <img src="{{ asset('storage/' . $psi->avatar) }}" alt="{{ $psi->name }}">
                @else
                <div class="psychologist-avatar-text">
                  {{ strtoupper(substr($psi->name, 0, 1)) }}
                </div>
                @endif
              </div>
            </div>

            <div class="psychologist-body">
              <h5 class="psychologist-name">{{ Str::limit($psi->name, 20) }}</h5>
              <div class="psychologist-role">Psikolog Klinis</div>

              <div class="psychologist-schedule">
                <div class="text-muted small mb-1">Jadwal Praktik:</div>
                <div class="fw-bold text-success">
                  <i class="bi bi-clock me-1"></i>
                  {{ \Carbon\Carbon::parse($psi->psikolog->jam_mulai)->format('H:i') }} -
                  {{ \Carbon\Carbon::parse($psi->psikolog->jam_selesai)->format('H:i') }} WIB
                </div>
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
          <div class="feature-icon mx-auto mb-3">
            <i class="bi bi-person-heart"></i>
          </div>
          <h5 class="fw-bold text-muted">Belum ada data psikolog yang tersedia</h5>
          <p class="text-muted">Tim psikolog akan segera bergabung</p>
        </div>
        @endforelse
      </div>
    </div>
  </section>

  @include('components.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const emosiOptions = document.querySelectorAll('.emosi-option');
      const submitBtn = document.getElementById('submitMoodBtn');

      emosiOptions.forEach(option => {
        option.addEventListener('click', function() {
          const radio = this.querySelector('input[type="radio"]');
          radio.checked = true;

          emosiOptions.forEach(opt => {
            opt.classList.remove('selected');
          });

          this.classList.add('selected');

          submitBtn.disabled = false;
          submitBtn.innerHTML = `Simpan Mood: ${this.querySelector('.emosi-label').textContent}`;
        });
      });

      const modalEmosi = document.getElementById('modalEmosi');
      modalEmosi.addEventListener('hidden.bs.modal', function() {
        emosiOptions.forEach(opt => {
          opt.classList.remove('selected');
        });
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Simpan Mood';
      });
    });

    @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: "{{ session('success') }}",
      confirmButtonColor: '#059669',
      timer: 3000
    });
    @endif
  </script>

</body>

</html>