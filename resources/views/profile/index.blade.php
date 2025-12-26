<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Sistem Curhat</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#059669',
                        bgsoft: '#f0fdf4',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans text-gray-800 min-h-screen flex flex-col">

    <!-- NAVBAR DIHAPUS SESUAI PERMINTAAN -->

    <main class="flex-grow py-10 px-4 sm:px-6">
        <div class="max-w-4xl mx-auto">

            <!-- Logika Tombol Kembali Dinamis -->
            @php
            $dashboardRoute = 'dashboard'; // Default untuk Korban (role_id 3)
            $dashboardLabel = 'Dashboard';

            if(Auth::check()) {
            if(Auth::user()->role_id == 1) {
            $dashboardRoute = 'admin.dashboard';
            $dashboardLabel = 'Dashboard Admin';
            } elseif(Auth::user()->role_id == 2) {
            $dashboardRoute = 'dashboard.psikolog';
            $dashboardLabel = 'Dashboard Psikolog';
            }
            }
            @endphp

            <!-- Tombol Kembali -->
            <div class="mb-6">
                <a href="{{ route($dashboardRoute) }}" class="inline-flex items-center text-gray-500 hover:text-primary transition font-medium">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke {{ $dashboardLabel }}
                </a>
            </div>

            <!-- Logika Fallback -->
            @php
            if(!isset($profile) || !$profile) {
            $user = Auth::user();
            if($user->role_id == 2) $profile = $user->psikolog;
            elseif($user->role_id == 3) $profile = $user->korban;
            else $profile = null;
            }
            @endphp

            @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
                <div class="flex items-center"><i class="fas fa-check-circle mr-3"></i><span>{{ session('success') }}</span></div>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900"><i class="fas fa-times"></i></button>
            </div>
            @endif

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 relative">

                <!-- Banner Header -->
                <div class="h-48 bg-gradient-to-r from-emerald-600 to-teal-500 relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute top-0 right-0 p-4 opacity-20 text-white"><i class="fas fa-shapes text-8xl"></i></div>
                </div>

                <div class="px-8 pb-10">

                    <!-- AREA AVATAR -->
                    <div class="relative flex flex-col sm:flex-row justify-between items-end -mt-16 sm:-mt-20 mb-6 gap-4">
                        <div class="relative group">
                            <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full border-4 border-white bg-white shadow-md overflow-hidden flex items-center justify-center relative z-10 group-hover:border-emerald-200 transition-colors">
                                @if(Auth::user()->avatar && Auth::user()->avatar != 'avatar.png')
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-5xl font-bold uppercase">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                @endif

                                <label for="avatarInput" class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer z-20">
                                    <i class="fas fa-camera text-2xl mb-1"></i><span class="text-xs font-medium">Ubah Foto</span>
                                </label>
                            </div>
                            <form id="avatarForm" action="{{ route('profile.update.avatar') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*" onchange="document.getElementById('avatarForm').submit()">
                            </form>
                            <div class="absolute bottom-2 right-2 sm:bottom-3 sm:right-3 w-6 h-6 bg-green-500 border-4 border-white rounded-full z-30" title="Online"></div>
                        </div>

                        <!-- TOMBOL EDIT DIHUBUNGKAN KE HALAMAN EDIT -->
                        <div class="flex gap-3 mb-2 w-full sm:w-auto">
                            <a href="{{ route('profile.edit') }}" class="flex-1 sm:flex-none text-center px-6 py-2.5 bg-primary text-white rounded-xl font-medium shadow-md hover:bg-secondary transition hover:-translate-y-0.5">
                                <i class="fas fa-edit mr-2"></i> Edit Data Diri
                            </a>
                        </div>
                    </div>

                    <!-- DATA UTAMA -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                        <p class="text-gray-500 flex items-center gap-2 mt-1">
                            <i class="fas fa-envelope text-gray-400"></i> {{ Auth::user()->email }}
                            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-blue-100 text-blue-700 uppercase ml-2">
                                @if(Auth::user()->role_id == 3) Mahasiswa
                                @elseif(Auth::user()->role_id == 2) Psikolog
                                @else Admin @endif
                            </span>
                        </p>
                    </div>

                    <hr class="border-gray-100 mb-8">

                    <!-- DETAIL INFORMASI -->
                    <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-id-card text-primary"></i> Informasi Pribadi
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if(Auth::user()->role_id == 3)
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600"><i class="fas fa-birthday-cake"></i></div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Umur</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $profile->umur ?? '-' }} Tahun</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600"><i class="fas fa-venus-mars"></i></div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Jenis Kelamin</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $profile->jenis_kelamin ?? '-' }}</p>
                            </div>
                        </div>
                        @elseif(Auth::user()->role_id == 2)
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600"><i class="fas fa-clock"></i></div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Jadwal</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $profile->jadwal_tersedia ? \Carbon\Carbon::parse($profile->jadwal_tersedia)->format('d M Y, H:i') : '-' }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600"><i class="fas fa-calendar-alt"></i></div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Bergabung</p>
                                <p class="text-lg font-semibold text-gray-800">{{ Auth::user()->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    @include('components.footer')
</body>

</html>