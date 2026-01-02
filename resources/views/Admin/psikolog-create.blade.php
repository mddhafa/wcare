<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Psikolog Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0fdf4;
            color: #334155;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #065f46;
        }

        .form-control:focus {
            border-color: #059669;
            box-shadow: 0 0 0 0.25rem rgba(5, 150, 105, 0.25);
        }

        .btn-save {
            background-color: #059669;
            border: none;
            color: white;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-save:hover {
            background-color: #047857;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-custom">
                    <div class="card-header-custom d-flex align-items-center">
                        <a href="{{ route('admin.psikolog') }}" class="btn btn-light btn-sm rounded-circle me-3 text-success shadow-sm">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <h4 class="mb-0 fw-bold">Tambah Psikolog Baru</h4>
                    </div>
                    <div class="card-body p-4 bg-white">

                        @if ($errors->any())
                        <div class="alert alert-danger rounded-3 border-0 shadow-sm">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('admin.psikolog.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap & Gelar</label>
                                <input type="text" class="form-control py-2" id="name" name="name" placeholder="Contoh: Dr. Budi Santoso, M.Psi" value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control py-2" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control py-2" id="password" name="password" placeholder="Minimal 6 karakter" required>
                            </div>

                            <hr class="my-4 text-muted opacity-25">

                            <div class="row mb-3">
                                <label class="form-label mb-2">Jam Praktik (Opsional)</label>

                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-success border-end-0"><i class="bi bi-clock"></i></span>
                                        <input type="time" class="form-control border-start-0 ps-0 py-2" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}">
                                    </div>
                                    <div class="form-text text-muted small mt-1 ps-1">Waktu Mulai</div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-success border-end-0"><i class="bi bi-clock-history"></i></span>
                                        <input type="time" class="form-control border-start-0 ps-0 py-2" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}">
                                    </div>
                                    <div class="form-text text-muted small mt-1 ps-1">Waktu Selesai</div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-save shadow-lg py-2">
                                    <i class="bi bi-save2-fill me-2"></i> Simpan Data Psikolog
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>