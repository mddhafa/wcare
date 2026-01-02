<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
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
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .avatar-placeholder {
            background-color: #ecfdf5;
            color: #059669;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            min-width: 250px;
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

        .badge-online {
            background-color: rgba(25, 135, 84, 0.1) !important;
            color: #198754 !important;
            border-color: rgba(25, 135, 84, 0.25) !important;
        }

        .badge-offline {
            background-color: rgba(108, 117, 125, 0.1) !important;
            color: #6c757d !important;
            border-color: rgba(108, 117, 125, 0.25) !important;
        }

        .dot-online {
            background-color: #198754 !important;
        }

        .dot-offline {
            background-color: #6c757d !important;
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
                            <h4 class="fw-bold mb-0 text-white">Data Mahasiswa</h4>
                            <div class="d-flex align-items-center gap-2 text-white text-opacity-75 small">
                                <i class="bi bi-mortarboard-fill"></i>
                                <span id="totalCount">{{ $users->count() }}</span><span> akun terdaftar</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-3 w-100 w-lg-auto">
                        <div class="position-relative flex-grow-1 flex-lg-grow-0">
                            <i class="bi bi-search position-absolute text-white text-opacity-75" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                            <input type="text" id="searchInput" class="search-box" placeholder="Cari nama atau email...">
                        </div>
                        <a href="{{ route('admin.users.trash', ['source' => 'mahasiswa']) }}" class="btn btn-outline-light rounded-pill px-3 d-flex align-items-center gap-2" data-bs-toggle="tooltip" title="Lihat Data Terhapus">
                            <i class="bi bi-trash3"></i> <span class="d-none d-md-inline">Sampah</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0" id="mahasiswaTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="30%">Mahasiswa</th>
                                <th width="25%">Email</th>
                                <th width="20%">Bergabung</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="10%" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr class="data-row" data-user-id="{{ $user->user_id }}">
                                <td class="text-center text-muted loop-number">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 flex-shrink-0 border border-success border-opacity-25">
                                            @if($user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="avatar-img">
                                            @elseif($user->korban && $user->korban->foto && file_exists(public_path('uploads/' . $user->korban->foto)))
                                            <img src="{{ asset('uploads/' . $user->korban->foto) }}" alt="{{ $user->name }}" class="avatar-img">
                                            @else
                                            <div class="avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6 user-name">{{ $user->name }}</div>
                                            @if($user->korban)
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">
                                                {{ $user->korban->jenis_kelamin ?? '-' }} | {{ $user->korban->umur ?? '-' }} Thn
                                            </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-secondary user-email">{{ $user->email }}</td>
                                <td>
                                    <div class="d-flex align-items-center text-secondary">
                                        <i class="bi bi-calendar-event me-2 text-success opacity-50"></i>
                                        {{ $user->created_at->translatedFormat('d M Y') }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span id="status-badge-{{ $user->user_id }}" class="badge border rounded-pill px-3 py-2 {{ $user->active_status == 1 ? 'badge-online' : 'badge-offline' }}">
                                        <span class="d-inline-block rounded-circle me-1 {{ $user->active_status == 1 ? 'dot-online' : 'dot-offline' }}" style="width: 8px; height: 8px;"></span>
                                        <span class="status-text">{{ $user->active_status == 1 ? 'Online' : 'Offline' }}</span>
                                    </span>
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
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                                        <i class="bi bi-trash me-2"></i> Hapus Akun
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="noDataRow">
                                <td colspan="6" class="text-center py-5 text-muted bg-light">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                        <div class="bg-white p-3 rounded-circle shadow-sm mb-3"><i class="bi bi-mortarboard text-secondary display-6"></i></div>
                                        <h6 class="fw-bold text-dark">Data Kosong</h6>
                                        <p class="mb-0 small">Belum ada mahasiswa yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                            <tr id="noSearchFound" style="display: none;">
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                        <i class="bi bi-search text-secondary fs-1 mb-3 opacity-50"></i>
                                        <h6 class="fw-bold text-dark">Tidak Ditemukan</h6>
                                        <p class="mb-0 small">Tidak ada mahasiswa dengan nama/email tersebut.</p>
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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        function updateTableStatus(userId, isOnline) {
            const badge = document.getElementById(`status-badge-${userId}`);
            if (badge) {
                const dot = badge.querySelector('span');
                const text = badge.querySelector('.status-text');

                if (isOnline) {
                    badge.classList.remove('badge-offline');
                    badge.classList.add('badge-online');
                    dot.classList.remove('dot-offline');
                    dot.classList.add('dot-online');
                    text.innerText = 'Online';
                } else {
                    badge.classList.remove('badge-online');
                    badge.classList.add('badge-offline');
                    dot.classList.remove('dot-online');
                    dot.classList.add('dot-offline');
                    text.innerText = 'Offline';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Echo !== "undefined") {
                window.Echo.join('presence-chat')
                    .listen('.user.status', (e) => {
                        if (e && e.userId) {
                            updateTableStatus(e.userId, e.status == 1);
                        }
                    })
                    .here((users) => {
                        users.forEach(user => {
                            const uid = user.user_id || user.id;
                            updateTableStatus(uid, true);
                        });
                    });
            }
        });

        document.getElementById('searchInput').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('.data-row');
            let hasResult = false;
            let visibleCount = 0;

            rows.forEach(row => {
                let name = row.querySelector('.user-name').innerText.toLowerCase();
                let email = row.querySelector('.user-email').innerText.toLowerCase();
                if (name.includes(filter) || email.includes(filter)) {
                    row.style.display = '';
                    hasResult = true;
                    visibleCount++;
                    let numberCell = row.querySelector('.loop-number');
                    if (numberCell) numberCell.innerText = visibleCount;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('totalCount').innerText = visibleCount;
            let noSearchFound = document.getElementById('noSearchFound');
            let noDataRow = document.getElementById('noDataRow');

            if (noDataRow && filter.length > 0) noDataRow.style.display = 'none';

            if (filter.length === 0) {
                noSearchFound.style.display = 'none';
                if (noDataRow) noDataRow.style.display = '';
                rows.forEach((row, index) => {
                    row.style.display = '';
                    let numberCell = row.querySelector('.loop-number');
                    if (numberCell) numberCell.innerText = index + 1;
                });
                document.getElementById('totalCount').innerText = rows.length;
            } else {
                noSearchFound.style.display = hasResult ? 'none' : '';
                if (noDataRow) noDataRow.style.display = 'none';
            }
        });

        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akun ini akan dihapus sementara dan masuk ke Tong Sampah!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif

</body>

</html>