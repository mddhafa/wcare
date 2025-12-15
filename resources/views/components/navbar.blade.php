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
  }

  .btn-login-outline {
    color: #059669;
    border: 2px solid #059669;
    font-weight: 600;
    border-radius: 8px;
    padding: 0.4rem 1.2rem;
  }

  .btn-register-solid {
    background-color: #059669;
    color: white;
    border: 2px solid #059669;
    font-weight: 600;
    border-radius: 8px;
    padding: 0.4rem 1.5rem;
  }

  .user-dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.35rem 0.5rem 0.35rem 1rem;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 50px;
    text-decoration: none;
  }

  .avatar-wrapper {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    overflow: hidden;
  }

  .avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #059669, #10b981);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
  }

  .dropdown-menu-modern {
    border-radius: 12px;
    padding: 0.5rem;
  }

  .dropdown-item-modern {
    border-radius: 8px;
    padding: 0.6rem 1rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .dropdown-item-logout:hover {
    background-color: #fef2f2;
    color: #dc2626;
  }

  /* OFFCANVAS 50% WIDTH */
  .offcanvas-half {
    width: 50vw !important;
    max-width: 50vw !important;
  }

  /* Mobile optimization */
  @media (max-width: 576px) {
    .offcanvas-half {
      width: 80vw !important;
      /* HP kecil biar tetap nyaman */
      max-width: 80vw !important;
    }
  }
</style>

@php
$dashboardUrl = route('dashboard');
if(auth()->check()) {
if(auth()->user()->role_id == 1) $dashboardUrl = route('admin.dashboard');
elseif(auth()->user()->role_id == 2) $dashboardUrl = route('psikolog.dashboard-psikolog');
}
@endphp

<nav class="navbar navbar-expand-lg navbar-theme sticky-top">
  <div class="container">

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="{{ $dashboardUrl }}">
      <img src="{{ asset('images/Umy-logo.gif') }}" width="40" height="40" class="rounded-circle">
      <div class="ms-2 d-flex align-items-baseline">
        <span class="navbar-brand-text">Wcare</span>
        <span class="navbar-brand-sub d-none d-sm-inline">SISTEM CURHAT</span>
      </div>
    </a>

    <!-- TOGGLER MOBILE -->
    <button class="navbar-toggler border-0"
      type="button"
      data-bs-toggle="offcanvas"
      data-bs-target="#mobileMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- DESKTOP MENU -->
    <ul class="navbar-nav ms-auto align-items-center gap-3 d-none d-lg-flex">
      @auth
      <li class="nav-item dropdown">
        <a class="user-dropdown-toggle" data-bs-toggle="dropdown">
          <div class="text-end d-none d-md-block">
            <div class="fw-semibold">{{ Str::limit(Auth::user()->name, 15) }}</div>
            <small class="text-muted">
              @if(Auth::user()->role_id == 1) Administrator
              @elseif(Auth::user()->role_id == 2) Psikolog
              @else Mahasiswa
              @endif
            </small>
          </div>
          <div class="avatar-wrapper">
            @if(Auth::user()->avatar && Auth::user()->avatar != 'avatar.png')
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-100 h-100 object-fit-cover">
            @else
            <div class="avatar-placeholder">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
            @endif
          </div>
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-modern">
          <li><a class="dropdown-item-modern" href="{{ $dashboardUrl }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
          <li><a class="dropdown-item-modern" href="{{ Auth::user()->role_id==2 ? route('psikolog.profilepsikolog') : route('korban.profilekorban') }}"><i class="bi bi-person"></i> Profil</a></li>
          <li>
            <hr>
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST">@csrf
              <button class="dropdown-item-modern dropdown-item-logout w-100">
                <i class="bi bi-box-arrow-right"></i> Keluar
              </button>
            </form>
          </li>
        </ul>
      </li>
      @else
      <li><a class="btn btn-login-outline" href="{{ route('login') }}">Masuk</a></li>
      <li><a class="btn btn-register-solid" href="{{ route('register') }}">Daftar</a></li>
      @endauth
    </ul>
  </div>
</nav>

<!-- OFFCANVAS MOBILE -->
<div class="offcanvas offcanvas-end offcanvas-half" id="mobileMenu">
  <div class="offcanvas-header border-bottom">
    <h5 class="fw-bold text-success">Menu</h5>
    <button class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>

  <div class="offcanvas-body">
    <ul class="navbar-nav gap-3">
      @auth
      <li class="text-center">
        <div class="avatar-wrapper mx-auto mb-2">
          @if(Auth::user()->avatar && Auth::user()->avatar != 'avatar.png')
          <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-100 h-100 object-fit-cover">
          @else
          <div class="avatar-placeholder">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
          @endif
        </div>
        <strong>{{ Auth::user()->name }}</strong>
      </li>

      <li><a class="dropdown-item-modern" href="{{ $dashboardUrl }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
      <li><a class="dropdown-item-modern" href="{{ Auth::user()->role_id==2 ? route('psikolog.profilepsikolog') : route('korban.profilekorban') }}"><i class="bi bi-person"></i> Profil</a></li>
      <li>
        <form action="{{ route('logout') }}" method="POST">@csrf
          <button class="dropdown-item-modern dropdown-item-logout w-100">
            <i class="bi bi-box-arrow-right"></i> Keluar
          </button>
        </form>
      </li>
      @else
      <li><a class="btn btn-login-outline w-100" href="{{ route('login') }}">Masuk</a></li>
      <li><a class="btn btn-register-solid w-100" href="{{ route('register') }}">Daftar</a></li>
      @endauth
    </ul>
  </div>
</div>