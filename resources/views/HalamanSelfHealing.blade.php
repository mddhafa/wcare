<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Konten Self-Healing</title>
  
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/selfhealing.css') }}">
</head>

<body>

  <!-- Navbar -->
  @include('components.navbar')

  <!-- Konten Utama -->
  <main class="container py-4">
    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Info Emosi Terpilih -->
    @auth
    @if(auth()->user()->current_emosi_id && isset($currentEmosi))
        <div class="alert alert-info-custom alert-custom mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <i class="fas fa-filter"></i>
                <span>Menampilkan konten untuk emosi:</span>
                <strong class="text-uppercase">{{ $currentEmosi->nama_emosi }}</strong>
                
                <span style="font-size: 1.5rem;">
                @if($currentEmosi->id_emosi == 3)
                    😡
                @elseif($currentEmosi->id_emosi == 1)
                    😊
                @elseif($currentEmosi->id_emosi == 2)
                    😢
                @elseif($currentEmosi->id_emosi == 4)
                    😨
                @endif
                </span>
                
                <span class="badge-count">{{ $selfHealings->count() }} konten</span>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-edit me-1"></i>Ubah Emosi
            </a>
        </div>
    @else
        <div class="alert alert-warning-custom alert-custom mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Anda belum memilih emosi. 
            <a href="{{ route('dashboard') }}" class="alert-link fw-bold">Pilih emosi sekarang</a> 
            untuk mendapatkan konten yang sesuai dengan perasaan Anda.
        </div>
    @endif
    @endauth

    <!-- Page Header -->
    <div class="page-header">
      <h1 class="page-title">
        <i class="fas fa-heart-pulse"></i>
        Daftar Konten Self-Healing
      </h1>
    </div>

    @if($selfHealings->isEmpty())
        <div class="empty-state">
            <i class="fas fa-inbox fa-4x"></i>
            <p>Belum ada konten self-healing yang tersedia untuk emosi ini.</p>
            @auth
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.tambahkontensh') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah Konten
                </a>
            @endif
            @endauth
        </div>
    @else
        <div class="content-grid">
            @foreach($selfHealings as $content)
                <div class="content-card">
                    
                    <div class="card-image-wrapper">
                        @if($content->gambar)
                            <img src="{{ asset('storage/' . $content->gambar) }}" 
                                alt="{{ $content->judul }}" 
                                class="card-image">
                        @else
                            <div class="card-image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                    </div>

                    <div class="card-body-content">
                        <!-- Badge Emosi -->
                        @if($content->emosi)
                            <span class="badge-emosi">
                                {{ $content->emosi->nama_emosi }}
                            </span>
                        @endif
                        
                        <h2 class="card-title">{{ $content->judul }}</h2>
                        
                        <div class="card-meta">
                            <i class="fas fa-tag"></i>
                            <span>{{ $content->jenis_konten }}</span>
                        </div>
                        
                        <p class="card-description">{{ Str::limit($content->deskripsi, 120) }}</p>

                        <div class="card-footer-custom">
                            @if($content->link_konten)
                                <a href="{{ $content->link_konten }}" 
                                   target="_blank" 
                                   class="btn-view-content">
                                    <i class="fas fa-external-link-alt"></i>
                                    <span>Lihat Konten</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @auth
    @if(auth()->user()->role == 'admin')
        <a href="{{ route('admin.tambahkontensh') }}">
            <button class="btn-floating">
                <i class="fas fa-plus"></i>
            </button>
        </a>
    @endif
    @endauth

  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Footer -->
  @include('components.footer')

</body>
</html>