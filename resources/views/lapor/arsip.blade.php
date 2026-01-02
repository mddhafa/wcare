<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Laporan Selesai - Sistem Curhat</title>

    <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0fdf4;
            color: #334155;
            padding-top: 80px;
        }

        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1050;
            background-color: white;
        }

        .main-container {
            padding: 3rem 0;
            min-height: calc(100vh - 80px);
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

        .btn-back {
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            background-color: white;
            color: #059669;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
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
            color: white;
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

        .table-hover tbody tr:hover {
            background-color: #f0fdf4;
        }

        .badge-status {
            padding: 0.5em 1em;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-selesai {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            background-color: #ecfdf5;
            color: #059669;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }
    </style>
</head>

<body>

    <div class="navbar-fixed">
        @include('components.navbar')
    </div>

    <div class="container main-container">

        <div class="card card-custom">

            <div class="card-header-custom">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center gap-4">

                    <div class="d-flex align-items-center gap-4 w-100 w-lg-auto">
                        <a href="{{ route('psikolog.dashboard-psikolog') }}" class="btn btn-back shadow-sm" data-bs-toggle="tooltip" title="Kembali ke Dashboard">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h4 class="fw-bold mb-0 text-white">Arsip Laporan Selesai</h4>
                            <div class="d-flex align-items-center gap-2 text-white text-opacity-75 small">
                                <i class="bi bi-archive-fill"></i>
                                <span>Riwayat kasus yang telah diselesaikan</span>
                            </div>
                        </div>
                    </div>

                    <div class="position-relative flex-grow-1 flex-lg-grow-0">
                        <i class="bi bi-search position-absolute text-white text-opacity-75" style="top: 50%; left: 15px; transform: translateY(-50%);"></i>
                        <input type="text" id="search" class="search-box" placeholder="Cari pelapor, lokasi...">

                        <div id="loading-spinner" class="spinner-border text-white spinner-border-sm position-absolute d-none" role="status" style="top: 35%; right: 15px;">
                            <span class="visually-hidden">Loading...</span>
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
                                <th width="20%">Tanggal Selesai</th>
                                <th width="25%">Pelapor</th>
                                <th width="15%">Jenis</th>
                                <th width="15%">Status</th>
                                <th width="10%" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @forelse ($laporan as $index => $l)
                            <tr>
                                <td class="text-center text-muted">{{ $index + 1 }}</td>

                                <td>
                                    <div class="d-flex align-items-center text-secondary">
                                        <i class="bi bi-calendar-check me-2 text-success opacity-50"></i>
                                        <div>
                                            <div class="fw-medium text-dark">{{ \Carbon\Carbon::parse($l->updated_at)->format('d M Y') }}</div>
                                            <small class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($l->updated_at)->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 flex-shrink-0 border border-success border-opacity-25">
                                            {{ strtoupper(substr($l->korban->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium text-dark">{{ $l->korban->name ?? 'Anonim' }}</div>
                                            <small class="text-muted" style="font-size: 0.8rem;">
                                                <i class="bi bi-geo-alt me-1"></i> {{ Str::limit($l->lokasi, 20) }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                        {{ $l->jenis }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-status status-selesai">
                                        <i class="bi bi-check-circle-fill me-1"></i> {{ $l->status }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('lapor.show', $l->id) }}" class="btn btn-sm btn-outline-success rounded-pill fw-bold px-3 shadow-sm">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted bg-light">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                        <div class="bg-white p-3 rounded-circle shadow-sm mb-3">
                                            <i class="bi bi-inbox text-secondary display-6"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Arsip Kosong</h6>
                                        <p class="mb-0 small">Belum ada laporan yang diselesaikan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-top py-3">
                <small class="text-muted">Menampilkan semua arsip laporan selesai</small>
            </div>
        </div>
    </div>

    @include('components.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var query = $(this).val();
                $('#loading-spinner').removeClass('d-none');

                $.ajax({
                    url: "{{ route('lapor.arsip') }}",
                    type: "GET",
                    data: {
                        'search': query
                    },
                    success: function(data) {
                        $('#table-body').html(data);
                        $('#loading-spinner').addClass('d-none');
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + error);
                        $('#loading-spinner').addClass('d-none');
                    }
                });
            });
        });
    </script>
</body>

</html>