<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tong Sampah Pengguna - Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<body class="bg-bgsoft min-h-screen font-sans text-dark py-10 px-4">

    <div class="max-w-6xl mx-auto">

        <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-gray-100">

            <div class="bg-gradient-to-r from-red-600 to-red-800 px-8 py-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-10 pointer-events-none">
                    <i class="fa-solid fa-trash-can text-[150px] -mr-10 -mt-8"></i>
                </div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6">

                    @php
                    $backUrl = route('admin.dashboard');
                    if(request('source') == 'mahasiswa') $backUrl = route('admin.mahasiswa');
                    elseif(request('source') == 'psikolog') $backUrl = route('admin.psikolog');
                    @endphp

                    <a href="{{ $backUrl }}" class="shrink-0 bg-white/20 hover:bg-white text-white hover:text-red-700 backdrop-blur-sm w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 group" title="Kembali">
                        <i class="fa-solid fa-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
                    </a>

                    <div>
                        <h1 class="text-2xl font-bold flex items-center gap-3">
                            Tong Sampah Pengguna
                        </h1>
                        <p class="text-red-100 text-sm mt-1 opacity-90">
                            Data yang dihapus sementara dapat dikembalikan (Restore) atau dihapus permanen.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4">Nama Pengguna</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Dihapus Pada</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($deletedUsers as $user)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->role_id == 2)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Psikolog
                                    </span>
                                    @elseif($user->role_id == 3)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Mahasiswa
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Admin
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-regular fa-clock text-xs"></i>
                                        {{ $user->deleted_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <form action="{{ route('admin.user.restore', $user->user_id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-emerald-600 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200" title="Kembalikan Data">
                                            <i class="fa-solid fa-rotate-left mr-1"></i> Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.user.force_delete', $user->user_id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200" title="Hapus Selamanya">
                                            <i class="fa-solid fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-50 p-4 rounded-full mb-3">
                                            <i class="fa-solid fa-trash-can text-3xl text-gray-300"></i>
                                        </div>
                                        <p class="text-base font-medium text-gray-500">Tong sampah kosong</p>
                                        <p class="text-sm">Tidak ada data pengguna yang dihapus.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-xs text-gray-500 flex justify-between items-center">
                <span>Total: {{ $deletedUsers->count() }} data terhapus</span>
                <span>
                    <i class="fa-solid fa-circle-info mr-1"></i> Data yang dihapus permanen tidak dapat dikembalikan.
                </span>
            </div>

        </div>
    </div>

    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;

            Swal.fire({
                title: 'Hapus Permanen?',
                text: "Data ini akan hilang selamanya dan tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus Permanen!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        @if(session('success'))
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: "#059669",
            timer: 3000
        });
        @endif
    </script>

</body>

</html>