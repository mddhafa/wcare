<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <!-- LOGO & BRAND -->
    <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/dashboard') }}" style="color: #059669;">
      <i class="bi bi-heart-pulse-fill me-2 fs-4"></i>
      <span>Sistem Curhat</span>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">

        @auth
        <!-- MENU USER DROPDOWN -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            <!-- LOGIKA FOTO PROFIL -->
            @if(Auth::user()->avatar && Auth::user()->avatar != 'avatar.png')
            <!-- Jika ada foto -->
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
              alt="Foto Profil"
              class="rounded-circle border border-2 border-success"
              style="width: 35px; height: 35px; object-fit: cover;">
            @else
            <!-- Jika tidak ada foto (Pakai Inisial) -->
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold"
              style="width: 35px; height: 35px; font-size: 14px;">
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            @endif

            <!-- NAMA USER -->
            <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
          </a>

          <!-- DROPDOWN ITEMS -->
          <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3" aria-labelledby="navbarDropdown">

            <!-- Header Role -->
            <li>
              <h6 class="dropdown-header text-uppercase small text-muted">
                @if(Auth::user()->role_id == 1) Administrator
                @elseif(Auth::user()->role_id == 2) Psikolog
                @else Mahasiswa
                @endif
              </h6>
            </li>

            <!-- Menu Profil -->
            <li>
              <a class="dropdown-item py-2" href="{{ route('korban.profilekorban') }}">
                <i class="bi bi-person-circle me-2 text-primary"></i> Profil Saya
              </a>
            </li>

            <!-- Menu Dashboard Sesuai Role -->
            @if(Auth::user()->role_id == 1)
            <li>
              <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2 text-info"></i> Dashboard Admin
              </a>
            </li>
            @elseif(Auth::user()->role_id == 2)
            <li>
              <a class="dropdown-item py-2" href="{{ route('dashboard.psikolog') }}">
                <i class="bi bi-grid-fill me-2 text-info"></i> Dashboard Psikolog
              </a>
            </li>
            @endif

            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- Logout -->
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item py-2 text-danger">
                  <i class="bi bi-box-arrow-right me-2"></i> Keluar
                </button>
              </form>
            </li>
          </ul>
        </li>
        @else
        <!-- JIKA BELUM LOGIN -->
        <li class="nav-item">
          <a class="nav-link fw-semibold text-primary" href="{{ route('login') }}">Masuk</a>
        </li>
        <li class="nav-item ms-2">
          <a class="btn btn-success rounded-pill px-4" href="{{ route('register') }}">Daftar</a>
        </li>
        @endauth

      </ul>
    </div>
  </div>
</nav>