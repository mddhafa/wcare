<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Daftar - Sistem Curhat</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      font-family: 'Segoe UI', system-ui, sans-serif;
    }

    .register-box {
      background: white;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(5, 150, 105, 0.1);
      max-width: 450px;
      width: 100%;
      overflow: hidden;
      border: 1px solid #e2e8f0;
    }

    .header {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      color: white;
      padding: 40px 30px 30px;
      text-align: center;
      position: relative;
    }

    .header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .logo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 3px solid rgba(255, 255, 255, 0.3);
      margin: 0 auto 15px;
      display: block;
      position: relative;
    }

    .header h1 {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 8px;
      position: relative;
    }

    .header p {
      opacity: 0.9;
      font-size: 14px;
      position: relative;
    }

    .form-section {
      padding: 30px;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-label {
      display: block;
      font-weight: 600;
      color: #475569;
      margin-bottom: 6px;
      font-size: 14px;
    }

    .form-input {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #e2e8f0;
      border-radius: 10px;
      font-size: 15px;
      transition: all 0.2s;
      background: #f8fafc;
    }

    .form-input:focus {
      outline: none;
      border-color: #059669;
      background: white;
      box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }

    .grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .password-container {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      cursor: pointer;
      background: none;
      border: none;
      padding: 5px;
    }

    select.form-input {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      padding-right: 40px;
    }

    .register-button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      margin-top: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .register-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(5, 150, 105, 0.25);
    }

    .register-button:disabled {
      opacity: 0.7;
      cursor: not-allowed;
      transform: none !important;
    }

    .login-link {
      text-align: center;
      margin-top: 20px;
      color: #64748b;
      font-size: 14px;
    }

    .login-link a {
      color: #059669;
      font-weight: 600;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    #snackbar {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%) translateY(10px);
      background: #1e293b;
      color: white;
      padding: 12px 20px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      opacity: 0;
      transition: all 0.3s;
      z-index: 1000;
      max-width: 400px;
      width: auto;
      text-align: center;
      font-size: 14px;
    }

    #snackbar.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }

    #snackbar.success {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    #snackbar.error {
      background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }

    @media (max-width: 480px) {
      .register-box {
        max-width: 100%;
      }

      .header {
        padding: 30px 20px 25px;
      }

      .form-section {
        padding: 25px 20px;
      }

      .grid-2 {
        grid-template-columns: 1fr;
        gap: 15px;
      }
    }
  </style>
</head>

<body>
  <div id="snackbar"></div>
  <div class="register-box">
    <div class="header">
      <img src="{{ asset('images/WeCare.png') }}" alt="Logo" class="logo">
      <h1>Daftar Akun Baru</h1>
      <p>Bergabunglah dengan Wcare - Sistem Curhat</p>
    </div>

    <div class="form-section">
      <form id="registerForm">
        @csrf

        <div class="form-group">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="name" placeholder="Nama Anda" required class="form-input">
        </div>

        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" placeholder="email@contoh.com" required class="form-input">
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Umur</label>
            <input type="number" name="umur" placeholder="20" required min="15" max="100" class="form-input">
          </div>
          <div class="form-group">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" required class="form-input">
              <option value="" disabled selected>Pilih</option>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <div class="password-container">
            <input id="password" type="password" name="password" placeholder="Minimal 6 karakter" required minlength="6" class="form-input">
            <button type="button" toggle="#password" class="toggle-password">
              <i class="fa fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Konfirmasi Password</label>
          <div class="password-container">
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi password" required minlength="6" class="form-input">
            <button type="button" toggle="#password_confirmation" class="toggle-password">
              <i class="fa fa-eye"></i>
            </button>
          </div>
        </div>

        <input type="hidden" name="role_id" value="3">

        <button type="submit" class="register-button" id="submitBtn">
          <i class="fas fa-user-plus"></i>
          Daftar Sekarang
        </button>

        <p class="login-link">
          Sudah punya akun? <a href="{{ url('/login') }}">Masuk di sini</a>
        </p>
      </form>
    </div>
  </div>

  <script>
    function showSnackbar(message, type = 'info') {
      const snackbar = document.getElementById('snackbar');
      snackbar.textContent = message;
      snackbar.className = '';
      snackbar.classList.add('show', type);
      setTimeout(() => snackbar.classList.remove('show'), 4000);
    }

    document.addEventListener('click', function(e) {
      if (e.target.closest('.toggle-password')) {
        const button = e.target.closest('.toggle-password');
        const input = document.querySelector(button.getAttribute('toggle'));
        const icon = button.querySelector('i');
        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
          input.type = 'password';
          icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
      }
    });

    document.getElementById('registerForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const form = e.target;
      const submitBtn = document.getElementById('submitBtn');
      const originalText = submitBtn.innerHTML;
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const password = form.querySelector('#password').value;
      const confirmPassword = form.querySelector('#password_confirmation').value;

      if (password !== confirmPassword) {
        showSnackbar('Konfirmasi password tidak cocok!', 'error');
        return;
      }
      if (password.length < 6) {
        showSnackbar('Password minimal 6 karakter!', 'error');
        return;
      }

      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
      submitBtn.disabled = true;

      try {
        const formData = new FormData(form);
        const res = await fetch('/register', {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
          },
          body: formData
        });
        const result = await res.json();

        if (res.ok) {
          showSnackbar(result.message || 'Registrasi berhasil!', 'success');
          setTimeout(() => window.location.href = '/login', 2000);
        } else {
          let errorMsg = result.message || 'Terjadi kesalahan saat registrasi.';
          if (result.errors) {
            const firstKey = Object.keys(result.errors)[0];
            errorMsg = result.errors[firstKey][0];
          }
          showSnackbar(errorMsg, 'error');
          submitBtn.innerHTML = originalText;
          submitBtn.disabled = false;
        }
      } catch (error) {
        showSnackbar('Terjadi kesalahan koneksi.', 'error');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
      }
    });

    const passwordInput = document.querySelector('#password');
    const confirmInput = document.querySelector('#password_confirmation');

    function checkPasswordMatch() {
      if (passwordInput.value && confirmInput.value) {
        if (passwordInput.value === confirmInput.value) {
          confirmInput.style.borderColor = '#059669';
          confirmInput.style.boxShadow = '0 0 0 3px rgba(5, 150, 105, 0.1)';
        } else {
          confirmInput.style.borderColor = '#dc2626';
          confirmInput.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.1)';
        }
      }
    }
    passwordInput.addEventListener('input', checkPasswordMatch);
    confirmInput.addEventListener('input', checkPasswordMatch);
  </script>
</body>

</html>