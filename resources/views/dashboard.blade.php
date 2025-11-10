<!DOCTYPE html>
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
          </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>


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
  </footer>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
</html>