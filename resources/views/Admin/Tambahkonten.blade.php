<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Konten Self-Healing</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('css/tambahkonten.css') }}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body >

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

  <div class="max-w-xl w-full bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Tambah Konten Self-Healing</h2>

    <form action="/tambah/selfhealing" method="POST" enctype="multipart/form-data">
      <!-- Token CSRF hanya digunakan di Laravel -->
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="mb-4">
        <label class="block text-gray-600 font-medium mb-1">Jenis Konten</label>
        <input type="text" name="jenis_konten" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-blue-300">
      </div>

      <div class="mb-4">
        <label class="block text-gray-600 font-medium mb-1">Pilih Emosi</label>
        <select name="id_emosi" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-blue-300">
            <option value="">-- Pilih Emosi --</option>

            @foreach ($emosis as $emosi)
                <option value="{{ $emosi->id_emosi }}">
                    {{ $emosi->jenis_emosi }}
                </option>
            @endforeach

        </select>
    </div>

      <div class="mb-4">
        <label class="block text-gray-600 font-medium mb-1">Judul</label>
        <input type="text" name="judul" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-blue-300">
      </div>

      <div class="mb-4">
        <label class="block text-gray-600 font-medium mb-1">Link Konten</label>
        <input type="text" name="link_konten" placeholder="https://contoh.com/konten" 
        class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-blue-300">
      </div>

      <div class="mb-4">
        <label class="block text-gray-600 font-medium mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="4" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-blue-300"></textarea>
      </div>

      <div class="mb-4">
        <label class="block text-gray-600 font-medium mb-1">Gambar</label>
        <input type="file" name="gambar" accept="image/*" class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:ring-blue-300">
      </div>

      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
        Simpan
      </button>
    </form>
  </div>

</body>
</html>
