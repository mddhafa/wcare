<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Login - Sistem Curhat</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-container {
      display: flex;
      max-width: 1200px;
      width: 100%;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
      min-height: 700px;
    }

    .left-side {
      flex: 1;
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      color: white;
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    .left-side::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .left-side .logo {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      margin-bottom: 40px;
      position: relative;
      z-index: 1;
    }

    .left-side h2 {
      font-size: 2.5rem;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 24px;
      position: relative;
      z-index: 1;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .left-side p {
      font-size: 1.1rem;
      line-height: 1.6;
      opacity: 0.9;
      margin-bottom: 40px;
      position: relative;
      z-index: 1;
      max-width: 500px;
    }

    .left-side small {
      font-size: 0.9rem;
      opacity: 0.7;
      position: relative;
      z-index: 1;
      margin-top: auto;
    }

    .right-side {
      flex: 1.2;
      background: white;
      padding: 60px 50px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      width: 100%;
      max-width: 450px;
    }

    .logo-header {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 40px;
    }

    .logo-header img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 3px solid #e2e8f0;
      box-shadow: 0 8px 20px rgba(5, 150, 105, 0.1);
    }

    .logo-header div h3 {
      font-size: 1.8rem;
      font-weight: 700;
      color: #059669;
      margin-bottom: 4px;
    }

    .logo-header div p {
      font-size: 0.95rem;
      color: #64748b;
      font-weight: 500;
    }

    .login-card>h2 {
      font-size: 2rem;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 12px;
    }

    .login-card>p:first-of-type {
      color: #64748b;
      margin-bottom: 40px;
      font-size: 1.05rem;
      line-height: 1.5;
    }

    .form-group {
      margin-bottom: 28px;
    }

    .form-label {
      display: block;
      font-weight: 600;
      color: #475569;
      margin-bottom: 10px;
      font-size: 0.95rem;
    }

    .form-input {
      width: 100%;
      padding: 16px 20px;
      border: 2px solid #e2e8f0;
      border-radius: 14px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: #f8fafc;
    }

    .form-input:focus {
      outline: none;
      border-color: #059669;
      background: white;
      box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
    }

    .form-input::placeholder {
      color: #94a3b8;
    }

    .password-container {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      cursor: pointer;
      transition: color 0.3s ease;
      background: none;
      border: none;
      padding: 8px;
    }

    .toggle-password:hover {
      color: #059669;
    }

    .login-button {
      width: 100%;
      padding: 18px;
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      color: white;
      border: none;
      border-radius: 14px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
      box-shadow: 0 8px 20px rgba(5, 150, 105, 0.2);
    }

    .login-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 25px rgba(5, 150, 105, 0.3);
    }

    .login-button:active {
      transform: translateY(0);
    }

    .register {
      text-align: center;
      margin-top: 32px;
      color: #64748b;
      font-size: 1rem;
    }

    .register a {
      color: #059669;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .register a:hover {
      color: #047857;
      text-decoration: underline;
    }

    .footer-links {
      text-align: center;
      margin-top: 24px;
      color: #94a3b8;
      font-size: 0.9rem;
    }

    #snackbar {
      position: fixed;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%) translateY(20px);
      background: #1e293b;
      color: white;
      padding: 16px 28px;
      border-radius: 14px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      opacity: 0;
      transition: all 0.3s ease;
      z-index: 1000;
      max-width: 500px;
      width: auto;
      text-align: center;
    }

    #snackbar.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }

    @media (max-width: 992px) {
      .login-container {
        flex-direction: column;
        max-width: 500px;
        min-height: auto;
      }

      .left-side {
        padding: 40px 30px;
      }

      .left-side h2 {
        font-size: 2rem;
      }

      .right-side {
        padding: 40px 30px;
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 15px;
      }

      .left-side,
      .right-side {
        padding: 30px 20px;
      }

      .left-side h2 {
        font-size: 1.75rem;
      }

      .logo-header img {
        width: 60px;
        height: 60px;
      }

      .logo-header div h3 {
        font-size: 1.5rem;
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-card {
      animation: fadeInUp 0.6s ease-out;
    }
  </style>
</head>

<body>
  <div id="snackbar"></div>

  <div class="login-container">
    <div class="left-side">
      <img src="{{ asset('images/WeCare.png') }}" alt="Logo Wcare" class="logo">
      <h2>Ruang Aman dan Rahasia untuk Suara Anda</h2>
      <p>Wcare berkomitmen untuk menyediakan platform yang aman bagi setiap anggota komunitas universitas kami.
        Ungkapkan perasaan Anda dengan nyaman dan dapatkan dukungan yang Anda butuhkan.</p>
      <small>© 2025 Sistem Curhat - Universitas Muhammadiyah Yogyakarta</small>
    </div>

    <div class="right-side">
      <div class="login-card">
        <div class="logo-header">
          <img src="{{ asset('images/WeCare.png') }}" alt="Logo Wcare">
          <div>
            <h3>Wcare</h3>
            <p>Sistem Curhat UMY</p>
          </div>
        </div>

        <p>Selamat datang kembali! Silakan masuk ke akun Anda.</p>

        <form id="loginForm" action="{{ route('login') }}" method="POST" autocomplete="off">
          @csrf

          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email"
              name="email"
              placeholder="Masukkan email Anda"
              required
              class="form-input">
          </div>

          <div class="form-group">
            <label class="form-label">Kata Sandi</label>
            <div class="password-container">
              <input id="password-field"
                type="password"
                name="password"
                placeholder="Masukkan kata sandi Anda"
                required
                class="form-input">
              <button type="button"
                toggle="#password-field"
                class="toggle-password">
                <i class="fa fa-eye"></i>
              </button>
            </div>
          </div>

          <button type="submit" class="login-button">
            <i class="fas fa-sign-in-alt mr-2"></i> Masuk Akun
          </button>
        </form>

        <p class="register">
          Belum punya akun?
          <a href="{{ url('/register') }}">Daftar di sini</a>
        </p>

        <p class="footer-links">
          Pusat Bantuan | Kebijakan Privasi
        </p>
      </div>
    </div>
  </div>

  <script>
    function showSnackbar(message, type = 'info') {
      const snackbar = document.getElementById('snackbar');
      snackbar.textContent = message;

      snackbar.classList.remove('bg-green-600', 'bg-red-600', 'bg-blue-600', 'bg-gray-800');

      switch (type) {
        case 'success':
          snackbar.classList.add('bg-green-600');
          break;
        case 'error':
          snackbar.classList.add('bg-red-600');
          break;
        case 'info':
          snackbar.classList.add('bg-blue-600');
          break;
        default:
          snackbar.classList.add('bg-gray-800');
      }

      snackbar.classList.add('show');

      setTimeout(() => {
        snackbar.classList.remove('show');
      }, 4000);
    }

    $(document).on('click', '.toggle-password', function() {
      const toggle = $(this);
      const input = $(toggle.attr('toggle'));
      const icon = toggle.find('i');

      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });

    document.getElementById('loginForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);
      const submitButton = form.querySelector('.login-button');
      const originalText = submitButton.innerHTML;

      submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
      submitButton.disabled = true;

      try {
        const res = await fetch(form.action, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
          },
          body: formData,
          credentials: 'same-origin'
        });

        const result = await res.json();

        if (res.status === 200) {
          showSnackbar(result.message || 'Login berhasil!', 'success');

          setTimeout(() => {
            const role = result.data?.role;
            let redirectUrl = '/';

            if (role === 'admin') {
              redirectUrl = '/admin/dashboard';
            } else if (role === 'psikolog') {
              redirectUrl = '/psikolog/dashboard';
            } else if (role === 'korban') {
              redirectUrl = '/dashboard';
            }

            window.location.href = redirectUrl;
          }, 1500);

        } else {
          showSnackbar(result.message || 'Email atau kata sandi salah', 'error');
          submitButton.innerHTML = originalText;
          submitButton.disabled = false;
        }

      } catch (err) {
        showSnackbar('Terjadi kesalahan pada server', 'error');
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
      }
    });

    const inputs = document.querySelectorAll('.form-input');
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
      });

      input.addEventListener('blur', function() {
        this.parentElement.classList.remove('focused');
      });
    });
  </script>
</body>

</html>