<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tong Sampah Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="p-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-danger"><i class="bi bi-trash3-fill"></i> Tong Sampah Pengguna</h3>

            <!-- LOGIKA TOMBOL KEMBALI YANG LEBIH PINTAR -->
            @php
            $backUrl = route('admin.dashboard'); // Default jika tidak ada info
            $label = 'Dashboard';

            if(request('source') == 'mahasiswa') {
            $backUrl = route('admin.mahasiswa');
            $label = 'Data Mahasiswa';
            } elseif(request('source') == 'psikolog') {
            $backUrl = route('admin.psikolog');
            $label = 'Data Psikolog';
            }
            @endphp

            <a href="{{ $backUrl }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke {{ $label }}
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Nama</th>
                            <th>Role</th>
                            <th>Dihapus Pada</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deletedUsers as $user)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $user->name }} <br> <small class="text-muted fw-normal">{{ $user->email }}</small></td>
                            <td>
                                @if($user->role_id == 2) <span class="badge bg-info text-dark">Psikolog</span>
                                @elseif($user->role_id == 3) <span class="badge bg-secondary">Mahasiswa</span>
                                @else Admin @endif
                            </td>
                            <td>{{ $user->deleted_at->diffForHumans() }}</td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.user.restore', $user->user_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm"><i class="bi bi-arrow-counterclockwise"></i> Restore</button>
                                </form>
                                <form action="{{ route('admin.user.force_delete', $user->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i> Permanen</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Tong sampah kosong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(session('success'))
    <script>
        Swal.fire('Berhasil', '{{ session('
            success ') }}', 'success');
    </script>
    @endif
</body>

</html>