<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Sistem Curhat</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

  <!-- Snackbar -->
  <div id="snackbar" class="hidden fixed bottom-5 left-1/2 transform -translate-x-1/2 
      bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-500">
  </div>

  <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Register Akun</h2>

    <form id="registerForm" class="space-y-4">
      <input type="text" name="name" placeholder="Nama" required class="w-full border rounded-lg p-2">
      <input type="email" name="email" placeholder="Email" required class="w-full border rounded-lg p-2">
      <input type="password" name="password" placeholder="Password" required class="w-full border rounded-lg p-2">
      <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required class="w-full border rounded-lg p-2">
      <!-- <input type="dropdown" name="role" placeholder="Pilih Role" required class="w-full border rounded-lg p-2"> -->

      <!-- role_id default (contoh: 3 = korban) -->
      <input type="hidden" name="role_id" value="3">

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Daftar</button>
    </form>

    <p class="text-center mt-4 text-gray-600">
      Sudah punya akun?
      <a href="/login" class="text-blue-600 hover:underline">Login di sini</a>
    </p>
  </div>

  <script>
    // Fungsi Snackbar
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

    // Event submit
    document.getElementById('registerForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const form = e.target;
      const data = {
        name: form.name.value,
        email: form.email.value,
        password: form.password.value,
        password_confirmation: form.password_confirmation.value,
        role_id: form.role_id.value
      };

      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      try {
        const res = await fetch('{{ route('register') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
          },
          body: JSON.stringify(data)
        });

        let result = {};
        try {
          result = await res.json();
        } catch {
          result = { message: 'Terjadi kesalahan pada server.' };
        }

        if (res.status === 200 || res.status === 201) {
          showSnackbar(result.message || 'Registrasi berhasil!', 'success');
          setTimeout(() => window.location.href = '/login', 2000);
        } else {
          showSnackbar(result.message || 'Terjadi kesalahan saat registrasi.', 'error');
        }
      } catch (error) {
        console.error(error);
        showSnackbar('Terjadi kesalahan koneksi.', 'error');
      }
    });
  </script>

</body>
</html>
