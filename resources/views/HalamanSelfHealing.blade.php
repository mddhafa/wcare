<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pustaka Self-Healing - Sistem Curhat</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#059669',
                        secondary: '#047857',
                        dark: '#064e3b',
                        accent: '#fbbf24',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .aspect-video { aspect-ratio: 16/9; }
        .text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.1); }

        .emosi-card {
            transition: all .3s ease;
            border: 2px solid transparent;
        }
        .emosi-card:hover {
            transform: translateY(-3px);
            border-color: #10b981;
            background-color: #f0fdf4;
        }
        input[type="radio"]:checked + .emosi-card {
            border-color: #059669 !important;
            background-color: #ecfdf5 !important;
            box-shadow: 0 0 0 3px #d1fae5;
        }

        /* override jika stacking context masih bermasalah */
        .modal { z-index: 12050 !important; }
        .modal-backdrop { z-index: 12040 !important; }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800 min-h-screen flex flex-col">

    @php
    $dashboardUrl = route('dashboard');
    $roleLabel = 'Dashboard';
    if(auth()->check()) {
        $roleId = auth()->user()->role_id;
        if($roleId == 1) {
            $dashboardUrl = route('admin.dashboard');
            $roleLabel = 'Admin Panel';
        } elseif($roleId == 2) {
            $dashboardUrl = route('dashboard.psikolog');
            $roleLabel = 'Dashboard Psikolog';
        }
    }
    @endphp

    <header class="bg-gradient-to-br from-emerald-900 via-primary to-emerald-500 text-white relative overflow-hidden pb-32 pt-10">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
            <svg class="absolute right-0 top-0 h-full w-1/2 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex justify-between items-center mb-12">
                <div class="flex items-center gap-3 opacity-90">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                        <i class="fas fa-heart-pulse text-xl text-white"></i>
                    </div>
                    <span class="font-bold text-lg tracking-wide uppercase text-emerald-50">Sistem Curhat</span>
                </div>

                <a href="{{ $dashboardUrl }}" class="group flex items-center gap-2 px-5 py-2.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-full transition-all duration-300">
                    <i class="fas fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
                    <span class="font-medium text-sm">Kembali ke {{ $roleLabel }}</span>
                </a>
            </div>

            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-block px-4 py-1.5 rounded-full bg-emerald-800/50 border border-emerald-400/30 text-emerald-100 text-sm font-medium mb-6 backdrop-blur-sm">
                    ✨ Ruang Tenang Anda
                </div>
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 text-shadow leading-tight">
                    Pustaka <span class="text-accent">Self-Healing</span>
                </h1>
                <p class="text-lg md:text-xl text-emerald-100 leading-relaxed font-light">
                    Kumpulan konten terkurasi untuk membantu Anda menemukan ketenangan, mengelola emosi, dan merawat kesehatan mental.
                </p>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 -mt-24 relative z-20 pb-20">

        <!-- INFO MOOD -->
       @auth
    @if(auth()->user()->current_emosi_id && isset($currentEmosi))

        {{-- MOOD TERPILIH --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-1 mb-10 transition-all duration-300">
            <div class="bg-gradient-to-r from-emerald-50 to-white rounded-xl p-6 
                        flex flex-col md:flex-row items-center justify-between gap-6">

                {{-- Bagian Emoji & Teks --}}
                <div class="flex items-center gap-6">

                    {{-- Emoji --}}
                    <div class="relative">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center 
                                    text-5xl shadow-md border-4 border-emerald-100">

                            @if($currentEmosi->id_emosi == 1)
                                😊
                            @elseif($currentEmosi->id_emosi == 2)
                                😡
                            @elseif($currentEmosi->id_emosi == 3)
                                😢
                            @elseif($currentEmosi->id_emosi == 4)
                                😨
                            @else
                                😐
                            @endif

                        </div>

                        <span class="absolute -bottom-2 -right-2 bg-emerald-500 text-white 
                                     text-xs font-semibold px-2 py-1 rounded-md shadow">
                            MOOD
                        </span>
                    </div>

                    {{-- Teks --}}
                    <div>
                        <p class="text-gray-500 text-sm tracking-wide uppercase">
                            Rekomendasi Konten Untuk
                        </p>
                        <h2 class="text-3xl font-bold text-gray-800">
                            {{ $currentEmosi->nama_emosi }}
                        </h2>
                    </div>
                </div>

                {{-- Tombol Ubah Mood --}}
                @if(auth()->user()->role_id == 3)
                    <div>
                        <button class="btn btn-success btn-lg px-4 shadow"
                                data-bs-toggle="modal" data-bs-target="#modalEmosi">
                            <i class="fas fa-edit me-1"></i> Ubah Mood
                        </button>
                    </div>
                @endif

            </div>
        </div>

    @else

        {{-- BELUM MEMILIH EMOSI --}}
        <div class="alert alert-warning-custom alert-custom mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Anda belum memilih emosi. 
            <a href="{{ route('dashboard') }}" class="alert-link fw-bold">Pilih emosi sekarang</a>
            untuk mendapatkan konten yang sesuai dengan perasaan Anda.
        </div>

    @endif
@endauth



        <!-- CONTENT GRID -->
        @if(isset($selfHealings) && $selfHealings->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($selfHealings as $content)
            @php
            $videoID = null;
            $isYoutube = false;
            if ($content->link_konten) {
                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $content->link_konten, $matches)) {
                    $videoID = $matches[1];
                    $isYoutube = true;
                }
            }
            // determine id property (adjust if your model uses different primary key)
            $contentId = $content->id ?? $content->self_healing_id ?? null;
            @endphp

            <div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden group flex flex-col h-full border border-gray-100 content-card" data-id="{{ $contentId }}">

                <div class="relative w-full aspect-video bg-gray-900 group-hover:opacity-100 transition-opacity">

                    @if($isYoutube && $videoID)
                    <iframe
                        class="w-full h-full pointer-events-auto"
                        src="https://www.youtube.com/embed/{{ $videoID }}?rel=0&modestbranding=1"
                        title="{{ $content->judul }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                    @elseif($content->gambar)
                    <img src="{{ asset('storage/' . $content->gambar) }}"
                        alt="{{ $content->judul }}"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 card-image">

                    <a href="{{ $content->link_konten }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <div class="bg-white text-gray-900 rounded-full p-4 shadow-lg transform scale-75 group-hover:scale-100 transition-transform">
                            <i class="fas fa-external-link-alt text-xl"></i>
                        </div>
                    </a>
                    @else
                    <div class="flex flex-col items-center justify-center h-full text-gray-500 bg-gray-100">
                        <i class="fas fa-image text-3xl mb-2 opacity-50"></i>
                        <span class="text-xs">No Preview</span>
                    </div>
                    @endif

                    <div class="absolute top-4 left-4">
                        <span class="bg-white/90 backdrop-blur-md text-gray-800 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm flex items-center gap-2">
                            @if($isYoutube)
                            <i class="fas fa-play text-red-500"></i> Video
                            @else
                            <i class="fas fa-book-open text-blue-500"></i> Artikel
                            @endif
                        </span>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    @if($content->emosi)
                    <div class="mb-3">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md uppercase tracking-wider">
                            {{ $content->emosi->nama_emosi }}
                        </span>
                    </div>
                    @endif

                    <h3 class="text-xl font-bold text-gray-900 mb-3 leading-snug group-hover:text-primary transition-colors">
                        {{ $content->judul }}
                    </h3>

                    <p class="text-gray-500 text-sm leading-relaxed mb-6 flex-grow line-clamp-3">
                        {{ \Illuminate\Support\Str::limit($content->deskripsi, 120) }}
                    </p>

                    <div class="mt-auto pt-5 border-t border-gray-100 flex justify-between items-center">
                        @if(!$isYoutube && $content->link_konten)
                        <a href="{{ $content->link_konten }}" target="_blank" class="text-sm font-bold text-primary hover:text-secondary flex items-center gap-2 group/link">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right transform group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                        @elseif($isYoutube)
                        <span class="text-xs font-medium text-gray-400 flex items-center gap-1">
                            <i class="fab fa-youtube"></i> Tonton Video
                        </span>
                        @else
                        <span class="text-xs text-gray-400">Info Only</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-3xl shadow-lg p-12 text-center max-w-2xl mx-auto border border-gray-100">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-wind text-gray-300 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Konten</h3>
            <p class="text-gray-500 leading-relaxed mb-8">
                Maaf, belum ada konten self-healing yang diunggah untuk kategori emosi ini.
                @if(auth()->check() && auth()->user()->role_id == 3)
                Cobalah ubah mood Anda di Dashboard untuk melihat rekomendasi lainnya.
                @endif
            </p>
            @if(auth()->check() && auth()->user()->role_id == 3)
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-medium rounded-xl hover:bg-secondary transition-colors shadow-lg shadow-emerald-200">
                Ke Dashboard
            </a>
            @endif
        </div>
        @endif

    </main>

    <!-- -----------------------------
         Modal dipindah KE SINI (tepat sebelum footer / penutup body)
         supaya menjadi child langsung dari <body>
         ----------------------------- -->
    <form action="{{ route('emosi.pilih') }}" method="POST">
        @csrf
        <div class="modal fade" id="modalEmosi" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-2xl">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Bagaimana perasaanmu hari ini?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-6 col-md-3">
                                <label for="senang" class="w-100">
                                    <input type="radio" name="emosi_id" id="senang" value="1" class="visually-hidden">
                                    <div class="p-3 border rounded-4 text-center shadow-sm emosi-card" role="button" tabindex="0">
                                        <div class="fs-1">😊</div>
                                        <div class="fw-semibold mt-2">Senang</div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-6 col-md-3">
                                <label for="sedih" class="w-100">
                                    <input type="radio" name="emosi_id" id="sedih" value="2" class="visually-hidden">
                                    <div class="p-3 border rounded-4 text-center shadow-sm emosi-card" role="button" tabindex="0">
                                        <div class="fs-1">😢</div>
                                        <div class="fw-semibold mt-2">Sedih</div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-6 col-md-3">
                                <label for="marah" class="w-100">
                                    <input type="radio" name="emosi_id" id="marah" value="3" class="visually-hidden">
                                    <div class="p-3 border rounded-4 text-center shadow-sm emosi-card" role="button" tabindex="0">
                                        <div class="fs-1">😡</div>
                                        <div class="fw-semibold mt-2">Marah</div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-6 col-md-3">
                                <label for="takut" class="w-100">
                                    <input type="radio" name="emosi_id" id="takut" value="4" class="visually-hidden">
                                    <div class="p-3 border rounded-4 text-center shadow-sm emosi-card" role="button" tabindex="0">
                                        <div class="fs-1">😨</div>
                                        <div class="fw-semibold mt-2">Takut</div>
                                    </div>
                                </label>
                            </div>

                        </div>
                    </div>       


                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- jQuery (dipakai oleh skrip custom kamu) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap Bundle (JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(function() {
        // Saat user klik elemen .emosi-card, centang radio di dalam label terdekat
        $(document).on('click', '.emosi-card', function(e) {
            // cari input radio di dalam label terdekat
            var $label = $(this).closest('label');
            var $radio = $label.find('input[type="radio"]');
            if ($radio.length) {
                $radio.prop('checked', true).trigger('change');
                // tambahkan class selected agar visual lebih jelas (opsional)
                $('.emosi-card').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        // dukungan keyboard: tekan ENTER atau SPACE pada .emosi-card juga memeriksa radio
        $(document).on('keydown', '.emosi-card', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).trigger('click');
            }
        });

        // Validasi sederhana sebelum submit: pastikan ada radio yang terpilih
        $(document).on('submit', 'form[action="{{ route('emosi.pilih') }}"]', function(e) {
            var $form = $(this);
            var chosen = $form.find('input[name="emosi_id"]:checked').val();
            if (!chosen) {
                e.preventDefault();
                // bisa ganti dengan UI toast atau pesan modal
                alert('Silakan pilih perasaanmu terlebih dahulu.');
                return false;
            }
            // biarkan form submit normal (server akan memproses POST)
            return true;
        });

        // opsional: style selected state (CSS tambahan)
        $('<style>')
            .prop('type', 'text/css')
            .html('.emosi-card.selected{ border-color:#059669 !important; background-color:#ecfdf5 !important; box-shadow:0 0 0 3px #d1fae5; }')
            .appendTo('head');
    });
    </script>


    <!-- Footer -->
    @include('components.footer')

</body>

</html>
