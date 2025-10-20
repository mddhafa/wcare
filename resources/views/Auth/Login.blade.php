<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Curhat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div id="snackbar" class="hidden fixed bottom-5 left-1/2 transform -translate-x-1/2 
      bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-500">
    </div>
  
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

        <!-- Gunakan form Laravel normal -->
        <form id="loginForm" action="{{ route('login') }}" method="POST" class = "space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Email" required class="w-full border rounded-lg p-2">
            <input type="password" name="password" placeholder="Password" required class="w-full border rounded-lg p-2">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Login</button>
        </form>

        <p class="text-center mt-4 text-gray-600">
            Belum punya akun?
            <a href="{{ url('/register') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
        </p>
    </div>

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

    const role = result.data?.role; // ✅ gunakan data.role

    if (role === 'admin') {
      setTimeout(() => window.location.href = '/admin/dashboard', 1200);
    } else {
      setTimeout(() => window.location.href = '/dashboard', 1200);
    }

  } else {
    showSnackbar(result.message || 'Gagal login (' + res.status + ')', 'error');
  }
});
</script>


</body>
</html>
