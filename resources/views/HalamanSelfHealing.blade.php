<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pustaka Self-Healing - Sistem Curhat</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#059669', // Emerald 600
                        secondary: '#047857', // Emerald 700
                        dark: '#064e3b', // Emerald 900
                        accent: '#fbbf24', // Amber 400
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .aspect-video {
            aspect-ratio: 16 / 9;
        }

        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800 min-h-screen flex flex-col">

    <!-- LOGIKA PHP: URL BACK BUTTON -->
    @php
    $dashboardUrl = route('dashboard');
    $roleLabel = 'Dashboard';

    if(auth()->check()) {
    $roleId = auth()->user()->role_id;

    if($roleId == 1) {
    $dashboardUrl = route('admin.dashboard');
    $roleLabel = 'Admin Panel';
    }
    elseif($roleId == 2) {
    $dashboardUrl = route('dashboard.psikolog');
    $roleLabel = 'Dashboard Psikolog';
    }
    }
    @endphp

    <!-- HEADER / HERO SECTION (Pengganti Navbar) -->
    <header class="bg-gradient-to-br from-emerald-900 via-primary to-emerald-500 text-white relative overflow-hidden pb-32 pt-10">

        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
            <svg class="absolute right-0 top-0 h-full w-1/2 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <!-- Top Bar Navigation -->
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

            <!-- Hero Text -->
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

    <!-- MAIN CONTENT (Overlapping Header) -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 -mt-24 relative z-20 pb-20">

        <!-- INFO MOOD (Jika Login & Ada Mood) -->
        @auth
        @if(auth()->user()->current_emosi_id && isset($currentEmosi))
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-1 mb-10 transform hover:-translate-y-1 transition-transform duration-300">
            <div class="bg-gradient-to-r from-emerald-50 to-white rounded-xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6">

                <div class="flex items-center gap-6">
                    <div class="relative">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-4xl shadow-md border-4 border-emerald-50">
                            @if($currentEmosi->id_emosi == 3) 😡
                            @elseif($currentEmosi->id_emosi == 1) 😊
                            @elseif($currentEmosi->id_emosi == 2) 😢
                            @elseif($currentEmosi->id_emosi == 4) 😨
                            @else 😐
                            @endif
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-primary text-white text-xs font-bold px-2 py-1 rounded-md shadow-sm">
                            MOOD
                        </div>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Rekomendasi Konten Untuk</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $currentEmosi->nama_emosi }}</h2>
                    </div>
                </div>

                @if(auth()->user()->role_id == 3)
                <div class="flex-shrink-0">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-primary bg-emerald-100 hover:bg-emerald-200 transition-colors">
                        <i class="fas fa-sliders-h mr-2"></i> Ubah Mood
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif
        @endauth

        <!-- CONTENT GRID -->
        @if(isset($selfHealings) && $selfHealings->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($selfHealings as $content)
            @php
            // Logika Deteksi YouTube
            $videoID = null;
            $isYoutube = false;
            if ($content->link_konten) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $content->link_konten, $matches)) {
            $videoID = $matches[1];
            $isYoutube = true;
            }
            }
            @endphp

            <div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden group flex flex-col h-full border border-gray-100">

                <!-- MEDIA THUMBNAIL / PLAYER -->
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
                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">

                    <!-- Overlay Link -->
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

                    <!-- Type Badge -->
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

                <!-- CARD BODY -->
                <div class="p-6 flex flex-col flex-grow">
                    <!-- Category/Emotion Tag -->
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

                    <!-- CARD FOOTER -->
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
        <!-- EMPTY STATE -->
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

    <!-- Footer -->
    @include('components.footer')

</body>

</html>