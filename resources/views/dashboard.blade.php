<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sistem Curhat</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
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
      overflow-x: hidden;
      padding-top: 80px;
    }

    .navbar-fixed-wrapper {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      background: white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .banner-img {
      height: 320px;
      object-fit: cover;
      border-radius: 20px;
    }

    .carousel-inner {
      border-radius: 20px;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .carousel-item {
      height: 420px;           
    }
    
    .banner-img {
      width: 100%;
      height: 100%;
      object-fit: cover;        
      object-position: center;  
      border-radius: 12px;      
    }

    @media (max-width: 768px) {
      .carousel-item { height: 240px; }
    }

    .hero-section {
      background-color: #ffffff;
      border-bottom: 1px solid #e5e7eb;
      padding-bottom: 3rem;
    }

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
      width: 100%;
      height: 0%;
      background: var(--primary-color);
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

    .psikolog-card {
      border: none;
      border-radius: 20px;
      background: white;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s;
      height: 100%;
      display: flex;
      flex-direction: column;
      min-width: 280px;
      flex: 0 0 auto;
    }

    .psikolog-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .psikolog-header {
      background: linear-gradient(135deg, #059669 0%, #34d399 100%);
      height: 80px;
      position: relative;
    }

    .psikolog-avatar-wrapper {
      width: 90px;
      height: 90px;
      margin: -45px auto 10px;
      border-radius: 50%;
      border: 4px solid white;
      overflow: hidden;
      background-color: white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: relative;
      z-index: 2;
    }

    .psikolog-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .status-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background-color: #ffffff;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      color: #374151;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      z-index: 10;
    }

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

    .psikolog-slider-container {
      position: relative;
      overflow: hidden;
    }

    .psikolog-slider-wrapper {
      position: relative;
      width: 100%;
    }

    .psikolog-slider {
      display: flex;
      transition: transform 0.5s ease;
      gap: 1.5rem;
      padding: 0.5rem;
      width: max-content;
    }

    .slider-controls {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 1rem;
      margin-top: 2rem;
    }

    .slider-btn {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: white;
      border: 2px solid var(--primary-color);
      color: var(--primary-color);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .slider-btn:hover {
      background: var(--primary-color);
      color: white;
      transform: scale(1.1);
    }

    .slider-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    @media (max-width: 768px) {
      .psikolog-card {
        min-width: 260px;
      }
    }

    #toastContainer {
      position: fixed;
      top: 90px;
      right: 20px;
      z-index: 9999;
    }

    .toast-notification {
      background: white;
      padding: 16px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      border-left: 4px solid var(--primary-color);
      margin-bottom: 10px;
      min-width: 300px;
      animation: slideIn 0.3s ease;
      cursor: pointer;
    }

    @keyframes slideIn {
      from {
        transform: translateX(100%);
      }

      to {
        transform: translateX(0);
      }
    }

    .toast-avatar {
      width: 40px;
      height: 40px;
      min-width: 40px;
      min-height: 40px;
      border-radius: 50%;
      object-fit: cover;
      object-position: center;
      flex-shrink: 0;
      border: 1px solid #e5e7eb;
    }
  </style>
</head>

<body>

  <div class="navbar-fixed-wrapper">
    @include('components.navbar')
  </div>

  <div id="toastContainer"></div>

  <section class="hero-section pt-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5">
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

        <div class="col-lg-6">
          <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
              <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
              <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="{{ asset('images/bullying.png') }}" class="d-block w-100 banner-img shadow" alt="Banner 1">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('images/kekerasan.png') }}" class="d-block w-100 banner-img shadow" alt="Banner 2">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('images/Pelecehan.png') }}" class="d-block w-100 banner-img shadow" alt="Banner 3">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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

  <section class="py-5">
    <div class="container py-4">
      <div class="text-center mb-5">
        <h6 class="text-success fw-bold text-uppercase ls-1" style="letter-spacing: 1px;">Fitur Unggulan</h6>
        <h2 class="fw-bold">Apa yang Bisa Kamu Lakukan?</h2>
      </div>

      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="icon-wrapper"><i class="bi bi-robot"></i></div>
            <h5 class="fw-bold mb-2">AI Chatbot</h5>
            <p class="text-muted small mb-4">Teman curhat virtual yang siap mendengarkanmu kapan saja tanpa menghakimi.</p>
            <a href="{{ url('/chatbot') }}" class="btn btn-custom-outline btn-sm w-100 stretched-link">Mulai Chat</a>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="icon-wrapper"><i class="bi bi-person-heart"></i></div>
            <h5 class="fw-bold mb-2">Konseling Ahli</h5>
            <p class="text-muted small mb-4">Terhubung langsung dengan psikolog profesional untuk penanganan lebih lanjut.</p>
            <a href="{{ route('korban.chat.index') }}" class="btn btn-custom-outline btn-sm w-100 stretched-link">Hubungi</a>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="feature-card text-center">
            <div class="icon-wrapper"><i class="bi bi-shield-exclamation"></i></div>
            <h5 class="fw-bold mb-2">Lapor Masalah</h5>
            <p class="text-muted small mb-4">Laporkan tindak bullying atau kekerasan seksual di lingkungan kampus secara aman.</p>
            <a href="{{ route('lapor.create') }}" class="btn btn-custom-outline btn-sm w-100 stretched-link">Buat Laporan</a>
          </div>
        </div>

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

  <section class="py-5" style="background-color: #f3f4f6;">
    <div class="container py-4">
      <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
          <h6 class="text-success fw-bold text-uppercase ls-1" style="letter-spacing: 1px;">Tim Ahli</h6>
          <h2 class="fw-bold">Psikolog Profesional</h2>
        </div>
      </div>

      @php
      $team_psikolog = \App\Models\User::where('role_id', 2)
      ->with('psikolog')
      ->get();
      @endphp

      @if($team_psikolog->count() > 0)
      <div class="psikolog-slider-container">
        <div class="psikolog-slider-wrapper">
          <div class="psikolog-slider" id="psychologistSlider">
            @foreach($team_psikolog as $psi)

            @php
            $avatarUrl = '';
            if($psi->avatar && file_exists(public_path('storage/' . $psi->avatar))) {
            $avatarUrl = asset('storage/' . $psi->avatar);
            } elseif($psi->foto && file_exists(public_path('uploads/' . $psi->foto))) {
            $avatarUrl = asset('uploads/' . $psi->foto);
            } else {
            $avatarUrl = 'https://ui-avatars.com/api/?name='.urlencode($psi->name).'&background=d1fae5&color=047857';
            }
            @endphp

            <div class="psikolog-slider-item" data-psikolog-id="{{ $psi->user_id }}" data-avatar-url="{{ $avatarUrl }}">
              <div class="psikolog-card">
                <div class="psikolog-header">
                  <div class="status-badge" id="status-badge-{{ $psi->user_id }}">
                    @if($psi->active_status == 1)
                    <span class="text-success fw-bold d-flex align-items-center">
                      <i class="bi bi-circle-fill small me-1"></i> Online
                    </span>
                    @else
                    <span class="text-secondary fw-bold d-flex align-items-center">
                      <i class="bi bi-circle-fill small me-1"></i> Offline
                    </span>
                    @endif
                  </div>
                </div>

                <div class="psikolog-avatar-wrapper">
                  <img src="{{ $avatarUrl }}" alt="{{ $psi->name }}" class="psikolog-img">
                </div>

                <div class="card-body p-4 text-center pt-0">
                  <h5 class="fw-bold text-dark mb-1">{{ $psi->name }}</h5>
                  <p class="text-muted small mb-3">Psikolog Klinis</p>

                  <div class="bg-light rounded-3 p-2 border border-dashed mb-3">
                    <div class="text-muted" style="font-size: 0.75rem;">Jadwal Praktik:</div>
                    <div class="fw-bold text-success">
                      <i class="bi bi-clock me-1"></i>
                      @if($psi->psikolog && $psi->psikolog->jam_mulai && $psi->psikolog->jam_selesai)
                      {{ \Carbon\Carbon::parse($psi->psikolog->jam_mulai)->format('H:i') }} -
                      {{ \Carbon\Carbon::parse($psi->psikolog->jam_selesai)->format('H:i') }} WIB
                      @else
                      Jadwal belum tersedia
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        @if($team_psikolog->count() > 4)
        <div class="slider-controls">
          <button class="slider-btn" id="sliderPrevBtn"><i class="bi bi-chevron-left"></i></button>
          <button class="slider-btn" id="sliderNextBtn"><i class="bi bi-chevron-right"></i></button>
        </div>
        @endif
      </div>
      @else
      <div class="col-12 text-center py-5">
        <p class="text-muted">Belum ada data psikolog yang tersedia saat ini.</p>
      </div>
      @endif
    </div>
  </section>

  @include('components.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const slider = document.getElementById('psychologistSlider');
      const prevBtn = document.getElementById('sliderPrevBtn');
      const nextBtn = document.getElementById('sliderNextBtn');

      if (slider && prevBtn && nextBtn) {
        const cards = slider.querySelectorAll('.psikolog-slider-item');
        const cardWidth = cards[0].offsetWidth + 24;
        const containerWidth = slider.parentElement.offsetWidth;
        const totalCards = cards.length;
        const visibleCards = Math.floor(containerWidth / cardWidth);
        let currentPosition = 0;

        function updateSliderPosition() {
          slider.style.transform = `translateX(-${currentPosition}px)`;
          prevBtn.disabled = currentPosition <= 0;
          const maxScroll = (totalCards - visibleCards) * cardWidth;
          nextBtn.disabled = currentPosition >= maxScroll;
        }

        function nextSlide() {
          const maxScroll = (totalCards - visibleCards) * cardWidth;
          if (currentPosition < maxScroll) {
            currentPosition += cardWidth * visibleCards;
            if (currentPosition > maxScroll) currentPosition = maxScroll;
            updateSliderPosition();
          }
        }

        function prevSlide() {
          if (currentPosition > 0) {
            currentPosition -= cardWidth * visibleCards;
            if (currentPosition < 0) currentPosition = 0;
            updateSliderPosition();
          }
        }

        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);
        updateSliderPosition();
      }

      const audioContext = new(window.AudioContext || window.webkitAudioContext)();

      document.body.addEventListener('click', function() {
        if (audioContext.state === 'suspended') {
          audioContext.resume();
        }
      }, {
        once: true
      });

      function playNotificationSound() {
        if (audioContext.state === 'suspended') audioContext.resume();

        const o = audioContext.createOscillator();
        const g = audioContext.createGain();
        o.connect(g);
        g.connect(audioContext.destination);
        o.frequency.value = 1000;
        g.gain.setValueAtTime(0.1, audioContext.currentTime);
        g.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.5);
        o.start();
        o.stop(audioContext.currentTime + 0.5);
      }

      const toastContainer = document.getElementById('toastContainer');

      function showToast(senderName, message, avatarUrl = null) {
        const toast = document.createElement('div');
        toast.className = 'toast-notification';

        const imgHtml = avatarUrl ?
          `<img src="${avatarUrl}" class="toast-avatar" alt="Avatar">` :
          `<div class="bg-success rounded-circle p-2 text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px"><i class="bi bi-chat-dots-fill"></i></div>`;

        toast.innerHTML = `
                                    <div class="d-flex align-items-center gap-3">
                                        ${imgHtml}
                                        <div class="overflow-hidden">
                                            <strong class="d-block text-dark text-truncate" style="font-size:0.9rem">${senderName}</strong>
                                            <small class="text-muted text-truncate d-block" style="max-width: 250px;">${message}</small>
                                        </div>
                                    </div>
                                `;

        toast.onclick = () => window.location.href = "{{ route('korban.chat.index') }}";

        toastContainer.appendChild(toast);
        setTimeout(() => {
          toast.style.transform = 'translateX(0)';
          toast.style.opacity = '1';
        }, 10);
        setTimeout(() => {
          toast.style.opacity = '0';
          toast.style.transform = 'translateX(100%)';
          setTimeout(() => toast.remove(), 300);
        }, 4000);
      }

      const currentUserId = "{{ Auth::id() }}";

      function updatePsikologStatus(userId, isOnline) {
        const badge = document.getElementById(`status-badge-${userId}`);
        if (badge) {
          if (isOnline) {
            badge.innerHTML = `<span class="text-success fw-bold d-flex align-items-center"><i class="bi bi-circle-fill small me-1"></i> Online</span>`;
          } else {
            badge.innerHTML = `<span class="text-secondary fw-bold d-flex align-items-center"><i class="bi bi-circle-fill small me-1"></i> Offline</span>`;
          }
        }
      }

      if (typeof Echo !== "undefined") {
        window.Echo.join('presence-chat')
          .listen('.user.status', (e) => {
            if (e && e.userId) updatePsikologStatus(e.userId, e.status == 1);
          })
          .here((users) => {
            users.forEach(user => {
              const uid = user.user_id || user.id;
              updatePsikologStatus(uid, true);
            });
          });

        window.Echo.private(`chat.user.${currentUserId}`)
          .listen('.message.sent', (e) => {
            console.log("Pesan Baru:", e);

            playNotificationSound();

            let avatarUrl = null;
            const sliderItem = document.querySelector(`.psikolog-slider-item[data-psikolog-id="${e.chat.sender_id}"]`);
            if (sliderItem) {
              avatarUrl = sliderItem.dataset.avatarUrl;
            }

            showToast("Pesan Baru", e.chat.message, avatarUrl);
          });
      }
    });

    document.querySelectorAll('.feature-card').forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(20px)';
      setTimeout(() => {
        card.style.transition = 'all 0.5s ease';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, index * 150);
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