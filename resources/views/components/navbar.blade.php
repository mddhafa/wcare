<!-- NAVBAR Component -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <!-- Logo / Brand -->
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}" style="color:#14532d;">
      <img src="{{ asset('images/Umy-logo.gif') }}" width="40" height="40" class="me-2 rounded-circle" alt="Logo">
      <span>UMY Curhat</span>
    </a>

    <!-- Tombol Toggle untuk Mobile -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Navbar -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        
        <!-- Home -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('/') ? 'active fw-semibold' : '' }}" 
             href="{{ url('/') }}" style="color:#14532d;">
            <i class="bi bi-house-door me-1"></i> 
          </a>
        </li>

        <!-- Chat Bot -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('chatbot*') ? 'active fw-semibold' : '' }}" 
             href="{{ url('/chatbot') }}" style="color:#14532d;">
            <i class="bi bi-chat-dots me-1"></i> 
          </a>
        </li>

        <!-- Chat Psychologist -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('psychologist*') ? 'active fw-semibold' : '' }}" 
             href="{{ url('/') }}" style="color:#14532d;">
            <i class="bi bi-person-heart me-1"></i> 
          </a>
        </li>

        <!-- Self Healing -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('selfhealing*') ? 'active fw-semibold' : '' }}" 
             href="{{ url('/selfhealing') }}" style="color:#14532d;">
            <i class="bi bi-lightbulb me-1"></i>
          </a>
        </li>

        <!-- Report -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('report*') ? 'active fw-semibold' : '' }}" 
             href="{{ url('/') }}" style="color:#14532d;">
            <i class="bi bi-file-earmark-text me-1"></i> 
          </a>
        </li>

        <!-- Dropdown User (jika sudah login) -->
        @auth
        <li class="nav-item dropdown ms-lg-3">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" 
             role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#14532d;">
            <img src="{{ Auth::user()->avatar ?? asset('images/default-avatar.png') }}" 
                 alt="Avatar" width="32" height="32" class="rounded-circle me-2">
            <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="{{ url('/profile') }}">
                <i class="bi bi-person-circle me-2"></i> Profil
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ url('/settings') }}">
                <i class="bi bi-gear me-2"></i> Pengaturan
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                  <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
              </form>
            </li>
          </ul>
        </li>
        @else
        <!-- Tombol Login/Register jika belum login -->
        <li class="nav-item ms-lg-3">
          <a href="{{ url('/login') }}" class="btn btn-outline-success btn-sm me-2">
            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/register') }}" class="btn btn-success btn-sm">
            <i class="bi bi-person-plus me-1"></i> Daftar
          </a>
        </li>
        @endauth

      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<!-- Script untuk efek scroll pada navbar -->
<script>
  // Menambahkan class 'scrolled' saat user scroll
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });

  // Auto-close navbar saat menu diklik (mobile)
  document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
    link.addEventListener('click', function() {
      const navbarToggler = document.querySelector('.navbar-toggler');
      const navbarCollapse = document.querySelector('.navbar-collapse');
      
      if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
        navbarToggler.click();
      }
    });
  });
</script>