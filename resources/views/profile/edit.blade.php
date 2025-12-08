<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Sistem Curhat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#059669', bgsoft: '#f0fdf4' },
                    fontFamily: { sans: ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-bgsoft min-h-screen flex items-center justify-center py-10 px-4">

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-primary px-8 py-6 text-white flex justify-between items-center">
            <h2 class="text-xl font-bold">Edit Profil</h2>
            <a href="{{ route('korban.profilekorban') }}" class="text-emerald-100 hover:text-white transition">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>

        <form action="{{ route('profile.update.data') }}" method="POST" class="p-8 space-y-5">
            @csrf
            @method('PUT')

            <!-- Data Akun -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
            </div>

            <!-- Data Khusus Korban -->
            @if($user->role_id == 3)
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Umur</label>
                        <input type="number" name="umur" value="{{ old('umur', $profile->umur ?? '') }}" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none bg-white">
                            <option value="Laki-laki" {{ (old('jenis_kelamin', $profile->jenis_kelamin ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ (old('jenis_kelamin', $profile->jenis_kelamin ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
            @endif

            <!-- Data Khusus Psikolog -->
            @if($user->role_id == 2)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Tersedia</label>
                    <input type="datetime-local" name="jadwal_tersedia" value="{{ old('jadwal_tersedia', $profile->jadwal_tersedia ?? '') }}" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-primary focus:outline-none">
                </div>
            @endif

            <div class="pt-4">
                <button type="submit" class="w-full bg-primary text-white font-bold py-3 rounded-xl shadow hover:bg-green-700 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</body>
</html>