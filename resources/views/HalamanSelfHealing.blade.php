<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Konten Self-Healing</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('css/selfhealing.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Navbar -->
  <header>
    <h1 class="text-2xl font-bold text-gray-700 hover:text-blue-600 transition">
        <a href="@auth
            @if(Auth::user()->role == 'admin')
                {{ url('dashboard-admin') }}
            @elseif(Auth::user()->role == 'psikolog')
                {{ url('dashboard') }}
            @elseif(Auth::user()->role == 'korban')
                {{ url('dashboard') }}
            @else
                {{ route('halamanselfhealing') }}
            @endif
        @else
            {{ route('halamanselfhealing') }}
        @endauth" 
        class="hover:text-blue-600 transition">
            Sistem Curhat
        </a>
    </h1>
    <div class="auth-buttons">
      @auth
        <span style="margin-right: 10px;">Halo, {{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      @endauth
<!-- 
      @guest
        <a href="{{ route('login') }}"><button class="login-btn">Login</button></a>
        <a href="{{ route('register') }}"><button class="register-btn">Register</button></a>
      @endguest -->
    </div>
  </header>

  <!-- Konten Utama -->
  <main class="px-4">

    <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-700">Daftar Konten Self-Healing</h1>

        @if($selfHealings->isEmpty())
            <p class="text-gray-500">Belum ada konten self-healing yang tersedia.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($selfHealings as $content)
                    <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition">
                        
                        @if($content->gambar)
                            <img src="{{ asset('storage/' . $content->gambar) }}" 
                                alt="{{ $content->judul }}" 
                                class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                Tidak ada gambar
                            </div>
                        @endif

                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $content->judul }}</h2>
                            <p class="text-sm text-gray-600 mb-2">{{ $content->jenis_konten }}</p>
                            <p class="text-gray-700 text-sm mb-3">{{ Str::limit($content->deskripsi, 100) }}</p>

                            @if($content->link_konten)
                                <a href="{{ $content->link_konten }}" 
                                target="_blank" 
                                class="text-blue-600 hover:underline text-sm">
                                Lihat Konten
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="button-tambah"> 
        <a href="{{ route('admin.tambahkontensh') }}">
            <button class="fixed bottom-10 right-10 bg-blue-600 text-white p-5 rounded-full shadow-lg hover:bg-blue-700 transition">
                <icon class="fas fa-plus"></icon>
            </button>
        </a>
    </div>

  </main>

</body>
</html>