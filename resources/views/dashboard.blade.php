<!DOCTYPE html>
<<<<<<< HEAD
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sistem Curhat</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
  .navbar {
    position: relative;
    z-index: 1055;
    /* pastikan di atas banner/carousel */
  }

  .navbar form button {
    position: relative;
    z-index: 1060;
    /* biar klik-nya tidak ketimpa */
  }
</style>

<style>
  .banner-left img,
  .banner-right img,
  .banner-img {
    height: 260px;
    object-fit: cover;
    border-radius: 12px;
  }

  .carousel-indicators [data-bs-target] {
    background-color: #14532d;
  }

  @media (max-width: 768px) {

    .banner-left img,
    .banner-right img,
    .banner-img {
      height: 200px;
    }
  }
</style>

<body class="bg-light text-dark">
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#14532d;">
    <div class="container-fluid px-4"> <!-- 🔹 ubah di sini -->
      <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
        <img src="{{ asset('images/Umy-logo.gif') }}"
          alt="Logo"
          width="40"
          height="40"
          class="me-2 rounded-circle">
        UMY CURHAT
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav"> <!-- 🔹 dan ini -->
        <ul class="navbar-nav align-items-center">
          @auth
          <li class="nav-item me-3 text-white">
            Halo, {{ Auth::user()->name }}
          </li>
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button class="btn btn-light btn-sm text-dark">Logout</button>
            </form>
          </li>
          @endauth

          @guest
          <li class="nav-item me-2">
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
=======
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - UMY Curhat</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #f5f7fa;
      color: #333;
    }
    .navbar-brand {
      letter-spacing: 1.5px;
      font-weight: 600;
    }
    .hero-box {
      background: #ffffff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 2px 10px #0001;
    }
    .card:hover {
      transform: translateY(-4px);
      transition: 0.3s;
      box-shadow: 0 4px 18px #0002;
    }
    footer {
      margin-top: 40px;
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background:#006b72;">
    <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
    <img src="/path/to/logo.png" alt="Logo" width="32" height="32" class="me-2">
    UMY CURHAT
  </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          @auth
        <li class="nav-item d-flex align-items-center me-2 text-white">
            Halo, {{ Auth::user()->name }}
        </li>
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button class="btn btn-danger btn-sm">Logout</button>
            </form>
          </li>
          @endauth
          @guest
          <li class="nav-item me-2">
            <a href="{{ route('login') }}" class="btn btn-light btn-sm text-dark">Login</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Register</a>
>>>>>>> 9f19b2d005664097d4bde2ffd86e7f22eea44af3
          </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

<<<<<<< HEAD
  <!-- 🌿 CAROUSEL BANNER -->
  <!-- SECTION: Banner Sejajar -->
  <section class="py-4">
    <div class="container">
      <div class="row g-3 align-items-stretch">

        <!-- Banner kiri (Carousel) -->
        <div class="col-lg-8">
          <div id="bannerCarousel" class="carousel slide h-100" data-bs-ride="carousel">
            <div class="carousel-inner rounded-4 overflow-hidden shadow-sm">
              <div class="carousel-item active">
                <img src="{{ asset('images/banner2.png') }}" class="d-block w-100 banner-img" alt="Banner 1">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('images/banner2.png') }}" class="d-block w-100 banner-img" alt="Banner 2">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('images/banner2.png') }}" class="d-block w-100 banner-img" alt="Banner 3">
              </div>
            </div>

            <!-- Kontrol panah -->
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>

            <!-- Indikator (bulatan di bawah) -->
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active"></button>
              <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1"></button>
              <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2"></button>
            </div>
          </div>
        </div>

        <!-- Banner kanan (statis) -->
        <div class="col-lg-4">
          <div class="banner-right rounded-4 overflow-hidden shadow-sm h-100">
            <img src="{{ asset('images/banner1.png') }}" alt="Dukungan UMY" class="img-fluid w-100 banner-img">
          </div>
        </div>

      </div>
    </div>
  </section>


  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
  </div>


  <!-- HERO / BANNER -->
  <section class="py-5 bg-white border-bottom">
    <div class="container text-center">
      <div class="row align-items-center justify-content-center">
        <div class="col-lg-6">
          <h1 class="fw-bold mb-3" style="color:#14532d;">
            Temukan Keseimbangan Emosimu di <span class="text-success">Sistem Curhat</span>
          </h1>
          <p class="text-muted mb-4">
            Jelajahi fitur-fitur untuk mengelola emosi, berbagi cerita, dan menjaga kesehatan mentalmu.
          </p>
          <a href="#" class="btn btn-success btn-lg px-4">
            Measure Emotions
          </a>
        </div>
        <div class="col-lg-5 mt-4 mt-lg-0">
          <img src="/path/to/illustration.png" alt="Ilustrasi Emosi" class="img-fluid rounded-4 shadow-sm">
        </div>
      </div>
    </div>
  </section>

  <!-- FITUR SECTION -->
  <section class="py-5 bg-light">
    <div class="container">
      <h3 class="fw-bold text-center mb-5" style="color:#14532d;">
        Solusi Kesehatan Emosional di Tanganmu
      </h3>

      <div class="row g-4">
        <div class="col-md-6 col-lg-3">
          <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="mb-3">
                <i class="bi bi-emoji-smile fs-1 text-success"></i>
              </div>
              <h5 class="card-title fw-semibold">Chat With Bot</h5>
              <p class="text-muted small mb-3">Curhat cepat dan anonim dengan bot pendengar.</p>
              <a href="#" class="btn btn-outline-success btn-sm">Mulai</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="mb-3">
                <i class="bi bi-person-heart fs-1 text-success"></i>
              </div>
              <h5 class="card-title fw-semibold">Chat With Psychologist</h5>
              <p class="text-muted small mb-3">Konsultasi langsung dengan psikolog profesional.</p>
              <a href="#" class="btn btn-outline-success btn-sm">Mulai</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="mb-3">
                <i class="bi bi-file-earmark-text fs-1 text-success"></i>
              </div>
              <h5 class="card-title fw-semibold">Report</h5>
              <p class="text-muted small mb-3">Lihat laporan perkembangan emosimu secara berkala.</p>
              <a href="#" class="btn btn-outline-success btn-sm">Lihat</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-3">
          <div class="card text-center border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="mb-3">
                <i class="bi bi-lightbulb fs-1 text-success"></i>
              </div>
              <h5 class="card-title fw-semibold">Request Advice</h5>
              <p class="text-muted small mb-3">Dapatkan saran pribadi dari tim ahli kami.</p>
              <a href="#" class="btn btn-outline-success btn-sm">Minta Saran</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TENTANG UMY CURHAT -->
  <section class="py-5 bg-white border-top">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <img src="{{ asset('images/banner1.png') }}" alt="Tentang UMY Curhat" class="img-fluid rounded-4 shadow-sm">
        </div>
        <div class="col-lg-6">
          <h3 class="fw-bold mb-3" style="color:#14532d;">Tentang UMY Curhat</h3>
          <p class="text-muted">
            <strong>UMY Curhat</strong> adalah platform dukungan emosional yang dikembangkan oleh Universitas Muhammadiyah Yogyakarta.
            Kami hadir untuk membantu mahasiswa dan masyarakat dalam menjaga kesehatan mental, berbagi cerita,
            dan mendapatkan bantuan profesional secara aman dan rahasia.
          </p>
          <p class="text-muted mb-4">
            Dengan berbagai fitur seperti konsultasi dengan psikolog, bot curhat, dan laporan emosi, kami ingin memastikan
            setiap pengguna merasa didengar dan dimengerti.
          </p>
          <a href="#" class="btn btn-success px-4">Pelajari Lebih Lanjut</a>
        </div>
      </div>
    </div>
  </section>

  <!-- REVIEW SECTION -->
  <section class="py-5 bg-light border-top">
    <div class="container">
      <h3 class="fw-bold text-center mb-5" style="color:#14532d;">
        Apa Kata Pengguna Kami
      </h3>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <p class="text-muted fst-italic">
                “Sangat membantu ketika saya sedang stres menghadapi kuliah. Bot-nya responsif dan bisa membuat saya merasa lebih tenang.”
              </p>
              <div class="d-flex align-items-center mt-3">
                <img src="{{ asset('images/user1.jpg') }}" alt="User 1" width="50" height="50" class="rounded-circle me-3">
                <div>
                  <h6 class="mb-0 fw-semibold">Aulia Rahman</h6>
                  <small class="text-muted">Mahasiswa Psikologi</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <p class="text-muted fst-italic">
                “Konsultasi dengan psikolog di sini benar-benar membantu saya memahami diri sendiri. Terima kasih UMY Curhat!”
              </p>
              <div class="d-flex align-items-center mt-3">
                <img src="{{ asset('images/user2.jpg') }}" alt="User 2" width="50" height="50" class="rounded-circle me-3">
                <div>
                  <h6 class="mb-0 fw-semibold">Rizky Putri</h6>
                  <small class="text-muted">Mahasiswa Ekonomi</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <p class="text-muted fst-italic">
                “Fitur laporan emosinya keren! Bisa lihat perkembangan perasaan saya setiap minggu.”
              </p>
              <div class="d-flex align-items-center mt-3">
                <img src="{{ asset('images/user3.jpg') }}" alt="User 3" width="50" height="50" class="rounded-circle me-3">
                <div>
                  <h6 class="mb-0 fw-semibold">Dewi Anggraini</h6>
                  <small class="text-muted">Mahasiswi Hukum</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Ahli/Psikolog -->
      <div class="text-center mt-5">
        <h4 class="fw-bold mb-4" style="color:#14532d;">Tim Psikolog Kami</h4>
        <div class="row justify-content-center g-4">
          <div class="col-md-3">
            <div class="card border-0 shadow-sm">
              <img src="{{ asset('images/psikolog1.jpg') }}" class="card-img-top" alt="Psikolog 1">
              <div class="card-body text-center">
                <h6 class="fw-semibold mb-0">Dr. Siti Nurhaliza, M.Psi</h6>
                <small class="text-muted">Psikolog Klinis</small>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card border-0 shadow-sm">
              <img src="{{ asset('images/psikolog2.jpg') }}" class="card-img-top" alt="Psikolog 2">
              <div class="card-body text-center">
                <h6 class="fw-semibold mb-0">Bapak Ahmad Fauzan, M.Psi</h6>
                <small class="text-muted">Konselor Kesehatan Mental</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- FOOTER -->
  <footer class="text-center text-white py-4 mt-4" style="background-color:#14532d;">
    &copy; 2025 Universitas Muhammadiyah Yogyakarta
=======

  <!-- MAIN -->
  <main class="container mt-4">
    <div class="hero-box text-center">
      <p>Jelajahi berbagai fitur yang dirancang untuk membantu menjaga keseimbangan emosimu.</p>
      <button class="btn btn-teal text-white px-4 py-2" style="background:#28a5b8;">Measure Emotions</button>

      @auth
        <p class="mt-3">Halo, <strong>{{ Auth::user()->name }}</strong>! Selamat datang di Dashboard Sistem Curhat.</p>
      @else
        <p class="mt-3">Selamat datang di Sistem Curhat! Silakan login untuk menggunakan fitur.</p>
      @endauth
    </div>

    <hr class="my-4" />

    <div class="row g-4">
      <!-- LEFT Content -->
      <div class="col-lg-8">
        <div class="row g-4">
          @forelse($selfHealings as $content)
          <div class="col-md-6 col-xl-4">
            <div class="card h-100" onclick="window.location.href='{{ route('halamanselfhealing') }}'" style="cursor:pointer;">
              @if($content->gambar)
                <img src="{{ asset('storage/selfhealing/' . basename($content->gambar)) }}" class="card-img-top" style="height:150px;object-fit:cover;" />
              @endif
              <div class="card-body">
                <h5 class="card-title">
                  <a href="{{ asset('storage/selfhealing/' . basename($content->gambar)) }}" target="_blank" class="text-decoration-none text-teal" style="color:#006b72;">
                    {{ $content->judul }}
                  </a>
                </h5>
                <p class="card-text">{{ $content->jenis_konten }}</p>

                @auth
                  @if($content->link_konten)
                  <a href="{{ $content->link_konten }}" target="_blank" class="btn btn-sm text-white" style="background:#006b72;">Lihat Konten</a>
                  @endif
                @else
                  <a href="{{ route('login') }}" class="btn btn-sm text-white" style="background:#006b72;">Login untuk melihat</a>
                @endauth
              </div>
            </div>
          </div>
          @empty
            <p>Tidak ada konten self-healing untuk ditampilkan.</p>
          @endforelse
        </div>
      </div>

      <!-- RIGHT Content -->
      <div class="col-lg-4">
        <div class="d-grid gap-3">
          <button class="btn text-white py-2" style="background:#28a5b8;">Report</button>
          <button class="btn text-white py-2" style="background:#28a5b8;">Chat With Bot</button>
          <button class="btn text-white py-2" style="background:#28a5b8;">Chat With Psychologist</button>
          <button class="btn text-white py-2" style="background:#28a5b8;">Request Advice</button>
        </div>
      </div>
    </div>
  </main>

  <footer class="text-center text-white py-3 mt-5" style="background:#006b72;">
    &copy; 2024 Sistem Curhat
>>>>>>> 9f19b2d005664097d4bde2ffd86e7f22eea44af3
  </footer>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<<<<<<< HEAD
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>

=======

  <script>
    document.querySelectorAll('button').forEach(btn => {
      btn.addEventListener('click', () => {
        const isGuest = {{ Auth::check() ? 'false' : 'true' }};
        if (isGuest) {
          alert('Silakan login terlebih dahulu untuk menggunakan fitur ini.');
          window.location.href = "{{ route('login') }}";
        }
      });
    });
  </script>
</body>
>>>>>>> 9f19b2d005664097d4bde2ffd86e7f22eea44af3
</html>