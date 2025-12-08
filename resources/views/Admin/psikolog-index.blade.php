<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Psikolog - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0fdf4;
            color: #334155;
        }

        .main-container {
            padding: 3rem 0;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            background: white;
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            padding: 2rem;
            border-bottom: none;
        }

        .avatar-circle {
            width: 45px;
            height: 45px;
            background-color: #d1fae5;
            color: #065f46;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .table-custom th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            padding: 1.2rem 1.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-custom td {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        .table-hover tbody tr:hover {
            background-color: #f0fdf4;
        }

        .btn-back {
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            background-color: white;
            color: #059669;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .btn-back:hover {
            background-color: #ecfdf5;
            color: #047857;
            transform: translateY(-2px);
        }

        .search-box {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 0.6rem 1.2rem 0.6rem 2.5rem;
            width: 300px;
            color: white;
            transition: all 0.3s;
        }

        .search-box::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }

        .search-box:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            width: 320px;
        }

        .badge-total {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container main-container">

        <div class="card card-custom">

            <div class="card-header-custom">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">

                    <div class="d-flex align-items-center gap-4 w-100">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h3 class="fw-bold mb-1">Data Psikolog</h3>
                            <div class="d-flex align-items-center gap-2 text-white text-opacity-75">
                                <i class="bi bi-person-heart"></i>
                                <span>Tim ahli profesional yang tersedia</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <!-- PERBAIKAN: Menambahkan parameter source=psikolog -->
                        <a href="{{ route('admin.users.trash', ['source' => 'psikolog']) }}" class="btn btn-warning shadow-sm rounded-pill text-dark fw-bold btn-sm px-3">
                            <i class="bi bi-trash3-fill me-1"></i> Tong Sampah
                        </a>

                        <span class="badge-total border border-white border-opacity-25">
                            Total: {{ $users->count() }}
                        </span>

                        <div class="position-relative">
                            <i class="bi bi-search position-absolute text-white text-opacity-75" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                            <input type="text" class="search-box" placeholder="Cari psikolog...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="35%">Psikolog</th>
                                <th width="30%">Email</th>
                                <th width="20%" class="text-center">Status Akun</th>
                                <th width="10%" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 flex-shrink-0 border border-success border-opacity-25">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6">{{ $user->name }}</div>
                                            <small class="text-muted d-block" style="font-size: 0.8rem;">Psikolog Klinis</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-secondary">{{ $user->email }}</td>

                                <td class="text-center">
                                    @if($user->active_status == 1)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">
                                        <span class="d-inline-block bg-success rounded-circle me-1" style="width: 8px; height: 8px;"></span> Online
                                    </span>
                                    @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3 py-2">
                                        <span class="d-inline-block bg-secondary rounded-circle me-1" style="width: 8px; height: 8px;"></span> Offline
                                    </span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle shadow-sm border" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                            <li><a class="dropdown-item py-2" href="{{ route('admin.user.edit', $user->user_id) }}"><i class="bi bi-pencil me-2 text-warning"></i> Edit Data</a></li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.user.delete', $user->user_id) }}" method="POST" onsubmit="return confirmDelete(event)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                                        <i class="bi bi-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted bg-light">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                        <div class="bg-white p-3 rounded-circle shadow-sm mb-3">
                                            <i class="bi bi-person-x text-secondary display-6"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Data Kosong</h6>
                                        <p class="mb-0 small">Belum ada psikolog yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-top py-3">
                <small class="text-muted">Menampilkan semua data</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akun psikolog ini akan dihapus sementara dan masuk ke Tong Sampah!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('
            success ') }}',
            timer: 3000,
            showConfirmButton: false
        });
        @endif
    </script>
</body>

</html>