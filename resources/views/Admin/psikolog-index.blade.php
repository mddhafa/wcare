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
            width: 100%;
            min-width: 200px;
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
        }

        .hover-scale {
            transition: transform 0.2s;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <div class="container main-container">

        <div class="card card-custom">

            <div class="card-header-custom">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-4">

                    <div class="d-flex align-items-center gap-4 w-100 w-lg-auto">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-back shadow-sm" data-bs-toggle="tooltip" title="Kembali ke Dashboard">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h4 class="fw-bold mb-0 text-white">Data Psikolog</h4>
                            <div class="d-flex align-items-center gap-2 text-white text-opacity-75 small">
                                <i class="bi bi-people-fill"></i>
                                <span id="totalCount">{{ $users->count() }}</span><span> tenaga ahli terdaftar</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-3 w-100 w-lg-auto">

                        <div class="position-relative flex-grow-1 flex-lg-grow-0">
                            <i class="bi bi-search position-absolute text-white text-opacity-75" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                            <input type="text" id="searchInput" class="search-box" placeholder="Cari nama atau email...">
                        </div>

                        <a href="{{ route('admin.users.trash', ['source' => 'psikolog']) }}" class="btn btn-outline-light rounded-pill px-3 d-flex align-items-center gap-2" data-bs-toggle="tooltip" title="Lihat Data Terhapus">
                            <i class="bi bi-trash3"></i>
                            <span class="d-none d-md-inline">Sampah</span>
                        </a>

                        <a href="{{ route('admin.psikolog.create') }}" class="btn btn-light text-success fw-bold rounded-pill px-4 d-flex align-items-center gap-2 shadow-sm hover-scale">
                            <i class="bi bi-plus-lg"></i>
                            <span>Tambah Baru</span>
                        </a>

                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0" id="psikologTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="40%">Psikolog & Email</th>
                                <th width="25%">Jadwal Praktik</th>
                                <th width="20%" class="text-center">Status Akun</th>
                                <th width="10%" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr class="data-row">
                                <td class="text-center text-muted loop-number">{{ $loop->iteration }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 flex-shrink-0 border border-success border-opacity-25">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6 user-name">{{ $user->name }}</div>
                                            <div class="text-muted small user-email" style="font-size: 0.8rem;">
                                                <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    @if($user->psikolog && $user->psikolog->jam_mulai && $user->psikolog->jam_selesai)
                                    <div class="d-flex align-items-center text-secondary">
                                        <i class="bi bi-clock me-2 text-success"></i>
                                        <span class="fw-medium">
                                            {{ \Carbon\Carbon::parse($user->psikolog->jam_mulai)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($user->psikolog->jam_selesai)->format('H:i') }}
                                        </span>
                                        <span class="badge bg-light text-dark border ms-2" style="font-size: 0.7rem;">WIB</span>
                                    </div>
                                    @else
                                    <span class="badge bg-light text-muted border border-dashed fw-normal">
                                        <i class="bi bi-calendar-x me-1"></i> Belum diatur
                                    </span>
                                    @endif
                                </td>

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
                            <tr id="noDataRow">
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

                            <tr id="noSearchFound" style="display: none;">
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                        <i class="bi bi-search text-secondary fs-1 mb-3 opacity-50"></i>
                                        <h6 class="fw-bold text-dark">Tidak Ditemukan</h6>
                                        <p class="mb-0 small">Tidak ada psikolog dengan nama tersebut.</p>
                                    </div>
                                </td>
                            </tr>

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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('.data-row');
            let hasResult = false;

            rows.forEach(row => {
                let name = row.querySelector('.user-name').innerText.toLowerCase();
                let email = row.querySelector('.user-email').innerText.toLowerCase();

                if (name.includes(filter) || email.includes(filter)) {
                    row.style.display = '';
                    hasResult = true;
                } else {
                    row.style.display = 'none';
                }
            });

            let noDataRow = document.getElementById('noDataRow');
            let noSearchFound = document.getElementById('noSearchFound');

            if (!noDataRow) {
                if (hasResult) {
                    noSearchFound.style.display = 'none';
                } else {
                    noSearchFound.style.display = '';
                }
            }
        });

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
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
        @endif
    </script>
</body>

</html>