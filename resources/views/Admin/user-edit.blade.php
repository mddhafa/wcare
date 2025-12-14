<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#059669',
                        secondary: '#047857',
                        bgsoft: '#f0fdf4',
                        dark: '#334155',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-bgsoft min-h-screen font-sans text-dark py-10 px-4 flex items-center justify-center">

    <div class="max-w-4xl w-full">

        <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-gray-100">

            <div class="bg-gradient-to-r from-primary to-secondary px-8 py-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-10 pointer-events-none">
                    <i class="fa-solid fa-user-pen text-[150px] -mr-10 -mt-8"></i>
                </div>

                <div class="relative z-10 flex items-center gap-6">

                    <a href="{{ url()->previous() }}" class="shrink-0 bg-white/20 hover:bg-white text-white hover:text-primary backdrop-blur-sm w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 group" title="Kembali">
                        <i class="fa-solid fa-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
                    </a>

                    <div>
                        <h1 class="text-2xl font-bold">Edit Data
                            @if($user->role_id == 3) Mahasiswa
                            @elseif($user->role_id == 2) Psikolog
                            @else Admin
                            @endif
                        </h1>
                        <p class="text-emerald-100 text-sm mt-1 opacity-90 flex items-center gap-2">
                            <i class="fa-regular fa-id-card"></i> ID: {{ $user->user_id }}
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.user.update', $user->user_id) }}" method="POST" class="p-8 md:p-10">
                @csrf
                @method('PUT')

                @if ($errors->any())
                <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800">Perhatikan input berikut:</h3>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-primary border-b border-gray-100 pb-2 mb-4">Informasi Akun</h3>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition bg-gray-50 focus:bg-white">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition bg-gray-50 focus:bg-white">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                            <input type="password" name="password" placeholder="******"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition bg-gray-50 focus:bg-white">
                            <p class="text-xs text-gray-500 mt-1">*Biarkan kosong jika tidak ingin mengubah password.</p>
                        </div>
                    </div>

                    <div class="space-y-6">

                        @if($user->role_id == 3)
                        <h3 class="text-lg font-bold text-primary border-b border-gray-100 pb-2 mb-4">Data Mahasiswa</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Umur</label>
                                <input type="number" name="umur" value="{{ old('umur', $user->korban->umur ?? '') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary outline-none bg-gray-50 focus:bg-white">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                                <div class="relative">
                                    <select name="jenis_kelamin" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary outline-none bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                                        <option value="">- Pilih -</option>
                                        <option value="Laki-laki" {{ (old('jenis_kelamin', $user->korban->jenis_kelamin ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ (old('jenis_kelamin', $user->korban->jenis_kelamin ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @elseif($user->role_id == 2)
                        <h3 class="text-lg font-bold text-primary border-b border-gray-100 pb-2 mb-4">Jadwal Praktik</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jam Mulai</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                                        <i class="fa-regular fa-clock"></i>
                                    </span>
                                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $user->psikolog->jam_mulai ?? '') }}"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary outline-none bg-gray-50 focus:bg-white">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jam Selesai</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 pointer-events-none">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    </span>
                                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $user->psikolog->jam_selesai ?? '') }}"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary outline-none bg-gray-50 focus:bg-white">
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">*Jadwal praktik harian (WIB)</p>
                        @endif

                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                    <a href="{{ url()->previous() }}" class="px-6 py-3 rounded-full text-gray-500 font-bold hover:bg-gray-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-primary text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-secondary hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>

</html>