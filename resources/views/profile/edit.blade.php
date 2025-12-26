<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Sistem Curhat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#059669',
                        secondary: '#047857',
                        bgsoft: '#f0fdf4',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-bgsoft min-h-screen flex items-center justify-center py-10 px-4">

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">

        <div class="bg-gradient-to-r from-primary to-secondary px-8 py-6 text-white flex justify-between items-center shadow-md">
            <div class="flex items-center gap-3">
                <i class="fas fa-user-edit text-2xl"></i>
                <h2 class="text-xl font-bold tracking-wide">Edit Profil</h2>
            </div>

            @php
            $backRoute = Auth::user()->role_id == 2 ? route('psikolog.profilepsikolog') : route('korban.profilekorban');
            @endphp
            <a href="{{ $backRoute }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/40 transition text-white">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <form action="{{ route('profile.update.data') }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-user"></i>
                        </div>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none transition text-gray-700 bg-gray-50/50 hover:bg-white"
                            placeholder="Masukkan nama lengkap">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none transition text-gray-700 bg-gray-50/50 hover:bg-white"
                            placeholder="nama@email.com">
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            @if($user->role_id == 3)
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Umur</label>
                    <div class="relative">
                        <input type="number" name="umur" value="{{ old('umur', $profile->umur ?? '') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none text-gray-700 text-center"
                            placeholder="0">
                        <span class="absolute right-4 top-3 text-gray-400 text-sm">Thn</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary focus:outline-none text-gray-700 bg-white">
                        <option value="" disabled selected>Pilih...</option>
                        <option value="Laki-laki" {{ (old('jenis_kelamin', $profile->jenis_kelamin ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ (old('jenis_kelamin', $profile->jenis_kelamin ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>
            @endif

            @if($user->role_id == 2)
            @php
            // Helper untuk membuat opsi jam
            $times = [];
            for($i = 7; $i <= 21; $i++) {
                $h=str_pad($i, 2, '0' , STR_PAD_LEFT);
                $times[]="$h:00" ;
                $times[]="$h:30" ;
                }
                // Ambil value lama atau dari database, format H:i (e.g. 08:00)
                $oldMulai=old('jam_mulai', $profile->jam_mulai ? \Carbon\Carbon::parse($profile->jam_mulai)->format('H:i') : '');
                $oldSelesai = old('jam_selesai', $profile->jam_selesai ? \Carbon\Carbon::parse($profile->jam_selesai)->format('H:i') : '');
                @endphp

                <div class="bg-gray-50 p-5 rounded-2xl border border-dashed border-gray-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-bold text-primary uppercase tracking-wider">Jadwal Praktik</h3>
                        <div class="flex gap-2">
                            <button type="button" onclick="setPreset('08:00', '16:00')" class="text-xs bg-white border border-gray-200 hover:border-primary text-gray-600 hover:text-primary px-3 py-1 rounded-full transition shadow-sm">
                                Kantor (08-16)
                            </button>
                            <button type="button" onclick="setPreset('09:00', '17:00')" class="text-xs bg-white border border-gray-200 hover:border-primary text-gray-600 hover:text-primary px-3 py-1 rounded-full transition shadow-sm">
                                9 to 5
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 ml-1 uppercase">Mulai</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-primary">
                                    <i class="far fa-clock"></i>
                                </div>
                                <select id="jam_mulai" name="jam_mulai" class="w-full pl-9 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-gray-700 bg-white appearance-none cursor-pointer">
                                    <option value="" selected disabled>--:--</option>
                                    @foreach($times as $time)
                                    <option value="{{ $time }}" {{ $oldMulai == $time ? 'selected' : '' }}>{{ $time }} WIB</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1.5 ml-1 uppercase">Selesai</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-primary">
                                    <i class="fas fa-history"></i>
                                </div>
                                <select id="jam_selesai" name="jam_selesai" class="w-full pl-9 pr-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-gray-700 bg-white appearance-none cursor-pointer">
                                    <option value="" selected disabled>--:--</option>
                                    @foreach($times as $time)
                                    <option value="{{ $time }}" {{ $oldSelesai == $time ? 'selected' : '' }}>{{ $time }} WIB</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-3 text-center">Pilih jam operasional agar status Anda "Available".</p>
                </div>
                @endif

                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>

        </form>
    </div>

    <script>
        function setPreset(start, end) {
            const startSelect = document.getElementById('jam_mulai');
            const endSelect = document.getElementById('jam_selesai');

            if (startSelect && endSelect) {
                startSelect.value = start;
                endSelect.value = end;
            }
        }
    </script>

</body>

</html>