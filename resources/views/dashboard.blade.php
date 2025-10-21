<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sistem Curhat</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f4f7fb;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: #fff;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    header h1 {
      font-size: 24px;
      font-weight: 600;
      color: #2b4b80;
    }

    .auth-buttons button {
      border: none;
      padding: 8px 18px;
      border-radius: 6px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .login-btn { background-color: #e8ecf1; color: #333; margin-right: 8px; }
    .login-btn:hover { background-color: #d5dce5; }
    .register-btn { background-color: #3a7bd5; color: white; }
    .register-btn:hover { background-color: #2e68bb; }

    .logout-btn {
      background-color: #ff4d4f;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }

    .logout-btn:hover { background-color: #d9363e; }

    main {
      flex: 1;
      padding: 60px 80px;
      max-width: 1400px;
      margin: 0 auto;
      width: 100%;
    }

    section { margin-bottom: 60px; }

    .measure-section p {
      max-width: 800px;
      color: #555;
      margin-top: 8px;
      line-height: 1.7;
      font-size: 16px;
    }

    .measure-btn {
      display: inline-block;
      margin-top: 25px;
      padding: 12px 28px;
      background-color: #3a7bd5;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .measure-btn:hover {
      background-color: #2e68bb;
      transform: translateY(-2px);
    }

    hr {
      margin: 50px 0;
      border: 0;
      border-top: 1px solid #d9dee5;
    }

    /* Grid Self-Healing */
    .self-healing {
      display: flex;
      justify-content: space-between;
      gap: 40px;
      flex-wrap: wrap;
    }

    .self-healing-left {
      flex: 1.5;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 25px;
    }

    .healing-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .healing-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    .healing-card img {
      width: 100%;
      height: 140px;
      object-fit: cover;
    }

    .healing-card h3 {
      font-size: 17px;
      font-weight: 600;
      color: #2b4b80;
      margin-bottom: 6px;
    }

    .healing-card p {
      font-size: 14px;
      color: #666;
      margin-bottom: 8px;
    }

    .healing-card a {
      color: #3a7bd5;
      font-size: 14px;
      text-decoration: none;
      font-weight: 500;
    }

    .healing-card a:hover {
      text-decoration: underline;
    }

    .healing-card div {
      padding: 14px;
    }

    .self-healing-right {
      flex: 0.6;
      display: flex;
      flex-direction: column;
      gap: 15px;
      align-items: center;
    }

    .self-healing-right button {
      width: 80%;
      background-color: #3a7bd5;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      font-size: 15px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .self-healing-right button:hover {
      background-color: #2e68bb;
      transform: translateY(-3px);
    }

    footer {
      background-color: #fff;
      text-align: center;
      padding: 18px;
      border-top: 1px solid #ddd;
      color: #666;
      font-size: 14px;
    }

    @media (max-width: 992px) {
      main { padding: 40px 30px; }
      .self-healing { flex-direction: column; }
      .self-healing-right { width: 100%; }
    }
  </style>
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

    <section class="self-healing">
      <div class="self-healing-left">
        @forelse($selfHealings as $content)
          <div class="healing-card ">
            @if($content->gambar)
              <img src="{{ asset('storage/selfhealing/' . basename($content->gambar)) }}" alt="{{ $content->judul }}">
            @endif
            <div>
              <h3>{{ $content->judul }}</h3>
              <p>{{ $content->jenis_konten }}</p>
              @auth
                @if($content->link_konten)
                  <a href="{{ $content->link_konten }}" target="_blank">Lihat Konten</a>
                @endif
              @else
                <a href="{{ route('login') }}">Login untuk melihat</a>
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
