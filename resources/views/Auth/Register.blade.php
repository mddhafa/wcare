<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Register - Sistem Curhat</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome untuk ikon mata (password) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen" style="background-color: #f0fdf4;"> <!-- Background soft green -->

  <!-- Snackbar -->
  <div id="snackbar" class="hidden fixed bottom-5 left-1/2 transform -translate-x-1/2 
      bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-500 z-50">
  </div>

  <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border-t-4 border-emerald-600">
    <div class="text-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Daftar Akun Baru</h2>
      <p class="text-gray-500 text-sm mt-1">Bergabunglah dengan UMY Curhat</p>
    </div>

    <form id="registerForm" class="space-y-4">

      <!-- Nama -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" name="name" placeholder="Masukkan nama Anda" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email Kampus/Pribadi</label>
        <input type="email" name="email" placeholder="contoh@gmail.com" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
      </div>

      <!-- Data Tambahan (Korban) -->
      <div class="grid grid-cols-2 gap-4">
        <!-- Umur -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Umur</label>
          <input type="number" name="umur" placeholder="20" required min="15" max="100" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
        </div>

        <!-- Jenis Kelamin -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
          <select name="jenis_kelamin" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white">
            <option value="" disabled selected>Pilih...</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>
      </div>

      <!-- Password -->
      <div class="relative">
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input id="password" type="password" name="password" placeholder="Minimal 6 karakter" required class="w-full border border-gray-300 rounded-lg p-2.5 pr-10 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
        <i class="fa-regular fa-eye absolute right-3 top-9 text-gray-400 cursor-pointer toggle-password" toggle="#password"></i>
      </div>

      <!-- Konfirmasi Password -->
      <div class="relative">
        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi password" required class="w-full border border-gray-300 rounded-lg p-2.5 pr-10 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
      </div>

      <!-- role_id default (3 = korban) -->
      <input type="hidden" name="role_id" value="3">

      <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-2.5 rounded-lg hover:bg-emerald-700 transition duration-300 shadow-md">
        Daftar Sekarang
      </button>
    </form>

    <p class="text-center mt-6 text-gray-600 text-sm">
      Sudah punya akun?
      <a href="/login" class="text-emerald-600 font-semibold hover:underline">Login di sini</a>
    </p>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    // Toggle Password Visibility
    $(".toggle-password").click(function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    // Fungsi Snackbar
    function showSnackbar(message, type = 'info') {
      const snackbar = document.getElementById('snackbar');
      snackbar.textContent = message;
      snackbar.classList.remove('bg-gray-800', 'bg-green-600', 'bg-red-600');
      snackbar.classList.add(
        type === 'success' ? 'bg-green-600' :
        type === 'error' ? 'bg-red-600' :
        'bg-gray-800'
      );
      snackbar.classList.remove('hidden');
      snackbar.classList.add('opacity-100');
      setTimeout(() => {
        snackbar.classList.remove('opacity-100');
        setTimeout(() => snackbar.classList.add('hidden'), 500);
      }, 3000);
    }

    // Event submit
    document.getElementById('registerForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const form = e.target;
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const formData = new FormData(form);

      // Validasi password match di frontend (UX)
      const pw = formData.get('password');
      const pwConfirm = formData.get('password_confirmation');
      if (pw !== pwConfirm) {
        showSnackbar('Konfirmasi password tidak cocok!', 'error');
        return;
      }

      try {
        const res = await fetch('/register', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
          },
          body: formData
        });

        const result = await res.json().catch(() => ({
          message: 'Terjadi kesalahan pada server.'
        }));

        if (res.ok) {
          showSnackbar(result.message || 'Registrasi berhasil!', 'success');
          setTimeout(() => window.location.href = '/login', 2000);
        } else {
          // Menangkap pesan error validasi dari Laravel
          let errorMsg = result.message || 'Terjadi kesalahan saat registrasi.';
          if (result.errors) {
            // Ambil error pertama saja biar rapi
            const firstKey = Object.keys(result.errors)[0];
            errorMsg = result.errors[firstKey][0];
          }
          showSnackbar(errorMsg, 'error');
          console.error(result);
        }
      } catch (error) {
        console.error(error);
        showSnackbar('Terjadi kesalahan koneksi.', 'error');
      }
    });
  </script>

</body>

</html>