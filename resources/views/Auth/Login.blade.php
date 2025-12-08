<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login - Sistem Curhat</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div id="snackbar" class="hidden fixed bottom-5 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-500"> </div>
  <div class="page-wrapper">
    <div class="login-container">
      <!-- Bagian kiri -->
      <div class="left-side" style="background-color:#14532d;">
        <img src="{{ asset('images/Umy-logo.gif') }}" alt="Logo" class="logo">
        <h2>Ruang Aman dan Rahasia untuk Suara Anda.</h2>
        <p>UMY CURHAT berkomitmen untuk menyediakan platform yang aman bagi setiap anggota komunitas universitas kami.</p>
        <small>© 2025 Universitas Muhammadiyah Yogyakarta</small>
      </div>


      <!-- Bagian kanan -->
      <div class="right-side">
        <div class="login-card">
          <div class="logo-header">
            <img src="{{ asset('images/Umy-logo.gif') }}" alt="Logo">
            <div>
              <h3>UMY CURHAT</h3>
              <p>Universitas Muhammadiyah Yogyakarta</p>
            </div>
          </div>

          <!-- <h2>Masuk Akun</h2> -->
          <p>Selamat datang kembali! Silakan masuk ke akun Anda.</p>

          <form id="loginForm" action="{{ route('login') }}" method="POST" autocomplete="off" class="space-y-4">
            @csrf
            <div>
              <label class="block text-sm font-medium mb-1">Email</label>
              <input type="email" name="email" placeholder="Email" required class="w-full border rounded-lg p-2">
            </div>
            <div class="relative">
              <label class="block text-sm font-medium mb-1">Kata Sandi</label>
              <input id="password-field" type="password" name="password"
                placeholder="Masukkan kata sandi Anda"
                required
                class="w-full border rounded-lg p-2 pr-10">
              <span toggle="#password-field"
                class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Login</button>
          </form>

          <p class="register">Belum punya akun? <a href="{{ url('/register') }}">Daftar di sini</a></p>
          <p class="footer-links">Pusat Bantuan | Kebijakan Privasi</p>
        </div>
      </div>
    </div>
  </div>
</body>

<script>
  function showSnackbar(message, type = 'info') {
    const snackbar = document.getElementById('snackbar');
    snackbar.textContent = message;
    snackbar.classList.remove('bg-gray-800', 'bg-green-600', 'bg-red-600');
    snackbar.classList.add(type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-gray-800');
    snackbar.classList.remove('hidden');
    snackbar.classList.add('opacity-100');
    setTimeout(() => {
      snackbar.classList.remove('opacity-100');
      setTimeout(() => snackbar.classList.add('hidden'), 500);
    }, 3000);
  }

  $(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    const res = await fetch(form.action, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
      },
      body: formData,
      credentials: 'same-origin'
    });

    let result = {};
    try {
      result = await res.json();
    } catch (err) {
      showSnackbar('Terjadi kesalahan pada server', 'error');
      return;
    }

    if (res.status === 200) {
      showSnackbar(result.message || 'Login berhasil!', 'success');

      const role = result.data?.role;

      if (role === 'admin') {
        setTimeout(() => window.location.href = '/admin/dashboard', 1200);
      } else if (role === 'psikolog') {
        setTimeout(() => window.location.href = '/psikolog/dashboard', 1200);
      } else if (role === 'korban') {
        setTimeout(() => window.location.href = '/dashboard', 1200);
      } else {
        setTimeout(() => window.location.href = '/', 1200);
      }
      
    } else {
      showSnackbar(result.message || 'Gagal login (' + res.status + ')', 'error');
    }
  });
</script>

</html>