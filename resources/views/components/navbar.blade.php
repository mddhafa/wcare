<style>
  .navbar-theme {
    background-color: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    padding: 0.75rem 0;
    transition: all 0.3s ease;
  }

  .navbar-brand-text {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    letter-spacing: -0.5px;
    color: #059669;
    font-size: 1.35rem;
  }

  .navbar-brand-sub {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 500;
    margin-left: 8px;
    padding-left: 8px;
    border-left: 2px solid #cbd5e1;
    letter-spacing: 0.5px;
  }

  .nav-link-item {
    color: #475569;
    font-weight: 600;
    font-size: 0.95rem;
    padding: 0.5rem 1rem !important;
    transition: color 0.2s;
  }

  .nav-link-item:hover {
    color: #059669;
  }

  .btn-login-outline {
    color: #059669;
    border: 2px solid #059669;
    font-weight: 600;
    border-radius: 8px;
    padding: 0.4rem 1.2rem;
    transition: all 0.2s;
  }

  .btn-login-outline:hover {
    background-color: #ecfdf5;
    color: #047857;
  }

  .btn-register-solid {
    background-color: #059669;
    color: white;
    border: 2px solid #059669;
    font-weight: 600;
    border-radius: 8px;
    padding: 0.4rem 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.3);
    transition: all 0.2s;
  }

  .btn-register-solid:hover {
    background-color: #047857;
    border-color: #047857;
    transform: translateY(-1px);
    color: white;
  }

  .user-dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.35rem 0.5rem 0.35rem 1rem;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 50px;
    transition: all 0.2s;
    text-decoration: none;
  }

  .user-dropdown-toggle:hover,
  .user-dropdown-toggle[aria-expanded="true"] {
    background-color: #ffffff;
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
  }

  .user-name {
    font-weight: 600;
    color: #334155;
    font-size: 0.9rem;
    line-height: 1.2;
  }

  .user-role {
    font-size: 0.7rem;
    color: #64748b;
    font-weight: 500;
    text-transform: uppercase;
  }

  .avatar-wrapper {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
  }

  .dropdown-menu-modern {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    padding: 0.5rem;
    margin-top: 10px !important;
    min-width: 200px;
  }

  .dropdown-item-modern {
    border-radius: 8px;
    padding: 0.6rem 1rem;
    font-weight: 500;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.15s;
  }

  .dropdown-item-modern:hover {
    background-color: #f1f5f9;
    color: #0f172a;
  }

  .dropdown-item-modern i {
    font-size: 1.1rem;
    color: #94a3b8;
    transition: color 0.15s;
  }

  .dropdown-item-modern:hover i {
    color: #059669;
  }

  .dropdown-item-logout:hover {
    background-color: #fef2f2;
    color: #dc2626;
  }

  .dropdown-item-logout:hover i {
    color: #dc2626;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-theme sticky-top">

  @php
  $dashboardUrl = route('dashboard');
  if(auth()->check()) {
  $roleId = auth()->user()->role_id;
  if($roleId == 1) $dashboardUrl = route('admin.dashboard');
  elseif($roleId == 2) $dashboardUrl = route('psikolog.dashboard-psikolog');
  }
  @endphp

  <div class="container">

    <a class="navbar-brand d-flex align-items-center" href="{{ $dashboardUrl }}">
      <img src="{{ asset('images/Umy-logo.gif') }}" alt="Logo" width="40" height="40" class="rounded-circle shadow-sm">
      <div class="d-flex align-items-baseline ms-2">
        <span class="navbar-brand-text">Wcare</span>
        <span class="navbar-brand-sub d-none d-sm-inline-block">SISTEM CURHAT</span>
      </div>
    </a>

    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center gap-3 mt-3 mt-lg-0">

        @auth
        <li class="nav-item dropdown">
          <a class="user-dropdown-toggle no-arrow" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            <div class="d-none d-md-block text-end">
              <div class="user-name">{{ Str::limit(Auth::user()->name, 15) }}</div>
              <div class="user-role">
                @if(Auth::user()->role_id == 1) Administrator
                @elseif(Auth::user()->role_id == 2) Psikolog
                @else Mahasiswa
                @endif
              </div>
            </div>

            <div class="avatar-wrapper">
              @if(Auth::user()->avatar && Auth::user()->avatar != 'avatar.png')
              <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-100 h-100 object-fit-cover" alt="Avatar">
              @else
              <div class="avatar-placeholder">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
              </div>
              @endif
            </div>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern animate__animated animate__fadeIn">

            <li class="d-lg-none px-3 py-2 text-center border-bottom mb-2 bg-light rounded-2">
              <strong class="d-block text-dark">{{ Auth::user()->name }}</strong>
            </li>

            @if(Auth::user()->role_id == 1)
            <li><a class="dropdown-item-modern" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            @elseif(Auth::user()->role_id == 2)
            <li><a class="dropdown-item-modern" href="{{ route('psikolog.dashboard-psikolog') }}"><i class="bi bi-grid"></i> Dashboard</a></li>
            @endif

            @if(Auth::user()->role_id == 2)
            <li><a class="dropdown-item-modern" href="{{ route('psikolog.profilepsikolog') }}"><i class="bi bi-person-gear"></i> Profil Saya</a></li>
            @else
            <li><a class="dropdown-item-modern" href="{{ route('korban.profilekorban') }}"><i class="bi bi-person-gear"></i> Profil Saya</a></li>
            @endif

            <li>
              <hr class="dropdown-divider my-2 opacity-25">
            </li>

            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item-modern dropdown-item-logout w-100 text-start">
                  <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
              </form>
            </li>
          </ul>
        </li>

        @else
        <li class="nav-item">
          <a class="btn btn-login-outline d-block text-center" href="{{ route('login') }}">Masuk</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-register-solid d-block text-center" href="{{ route('register') }}">Daftar</a>
        </li>
        @endauth

      </ul>
    </div>
  </div>
</nav>