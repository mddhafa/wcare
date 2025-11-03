 kj<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sistem Curhat</title>
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

</head>
<body>
  <header>
    <h1>Sistem Curhat</h1>
    <div class="auth-buttons">
      @auth
        <span style="margin-right: 10px;">Halo, {{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      @endauth

      @guest
        <a href="{{ route('login') }}"><button class="login-btn">Login</button></a>
        <a href="{{ route('register') }}"><button class="register-btn">Register</button></a>
      @endguest
    </div>
  </header>

  <main>
    <section class="measure-section">
      <p>Jelajahi berbagai fitur yang dirancang untuk membantu menjaga keseimbangan emosimu.</p>
      <button class="measure-btn feature-btn">Measure Emotions</button>

      @auth
        <p style="margin-top: 15px;">Halo, <strong>{{ Auth::user()->name }}</strong>! Selamat datang di Dashboard Sistem Curhat.</p>
      @else
        <p style="margin-top: 15px;">Selamat datang di Sistem Curhat! Silakan login untuk menggunakan fitur.</p>
      @endauth
    </section>

    <hr>

    <section class="menu">
      <div class="self-healing-grid">
        @forelse($selfHealings as $content)
          <div class="healing-card" onclick="window.location.href='{{ route('halamanselfhealing') }}'">
            @if($content->gambar)
              <img src="{{ asset('storage/selfhealing/' . basename($content->gambar)) }}" alt="{{ $content->judul }}">
            @endif
            <div class="healing-info">
              <!-- Klik judul menuju halaman gambar -->
              <h3>
                <a href="{{ asset('storage/selfhealing/' . basename($content->gambar)) }}" target="_blank">
                  {{ $content->judul }}
                </a>
              </h3>
              <p>{{ $content->jenis_konten }}</p>

              @auth
                @if($content->link_konten)
                  <a href="{{ $content->link_konten }}" target="_blank" class="btn-lihat">Lihat Konten</a>
                @endif
              @else
                <a href="{{ route('login') }}" class="btn-login">Login untuk melihat</a>
              @endauth
            </div>
          </div>
        @empty
          <p>Tidak ada konten self-healing untuk ditampilkan.</p>
        @endforelse
      </div>


      <div class="self-healing-right">
        <button class="feature-btn">Report</button>
        <button class="feature-btn">Chat With Bot</button>
        <button class="feature-btn">Chat With Psychologist</button>
        <button class="feature-btn">Request Advice</button>
      </div>
    </section>
  </main>

  <footer>
    &copy; 2024 Sistem Curhat
  </footer>

  <script>
    document.querySelectorAll('.feature-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const isGuest = {{ Auth::check() ? 'false' : 'true' }};
        if (isGuest) {
          alert('Silakan login terlebih dahulu untuk menggunakan fitur ini.');
          window.location.href = "{{ route('login') }}";
        } else {
          alert('Fitur akan segera dijalankan...');
        }
      });
    });
  </script>
</body>
</html>
