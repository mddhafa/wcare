<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sistem Curhat</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
    body { background-color: #f4f7fb; color: #333; display: flex; flex-direction: column; min-height: 100vh; }

    header {
      background-color: #fff;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 { font-size: 22px; font-weight: 600; color: #2b4b80; }

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

    main { flex: 1; padding: 40px 60px; max-width: 1200px; margin: 0 auto; }
    section { margin-bottom: 60px; }
    .measure-section p { max-width: 700px; color: #555; margin-top: 8px; line-height: 1.6; }

    .measure-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 24px;
      background-color: #3a7bd5;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 15px;
      transition: all 0.3s ease;
    }
    .measure-btn:hover { background-color: #2e68bb; transform: translateY(-2px); }

    hr { margin: 50px 0; border: 0; border-top: 1px solid #d9dee5; }

    .self-healing { display: flex; flex-wrap: wrap; align-items: flex-start; gap: 40px; }
    .self-healing-left { display: grid; grid-template-columns: repeat(2, 150px); gap: 20px; }
    .healing-card {
      background-color: #e5eaf1; width: 150px; height: 150px;
      border-radius: 10px; transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer;
    }
    .healing-card:hover { transform: translateY(-4px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }

    .self-healing-right { display: flex; flex-direction: column; gap: 12px; }
    .self-healing-right button {
      background-color: #f0f2f6; border: none; padding: 10px 20px; border-radius: 6px;
      font-size: 15px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;
    }
    .self-healing-right button:hover { background-color: #dbe2eb; transform: translateX(4px); }

    footer { background-color: #fff; text-align: center; padding: 15px; border-top: 1px solid #ddd; color: #666; font-size: 14px; }

    @media (max-width: 768px) {
      main { padding: 30px 20px; }
      .self-healing { flex-direction: column; align-items: center; }
      .self-healing-right { width: 100%; align-items: center; }
      .self-healing-right button { width: 80%; }
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
      <p>
        Jelajahi berbagai fitur yang dirancang untuk membantu menjaga keseimbangan emosimu.
      </p>
      <button class="measure-btn feature-btn">Measure Emotions</button>

      @auth
        <p>Halo, <strong>{{ Auth::user()->name }}</strong>! Selamat datang di Dashboard Sistem Curhat.</p>
      @else
        <p>Selamat datang di Sistem Curhat! Silakan login untuk menggunakan fitur.</p>
      @endauth
    </section>

    <hr>

    <section class="self-healing">
      <div class="self-healing-left">
        <div class="healing-card feature-btn"></div>
        <div class="healing-card feature-btn"></div>
        <div class="healing-card feature-btn"></div>
        <div class="healing-card feature-btn"></div>
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

  <!-- Proteksi fitur jika belum login -->
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
