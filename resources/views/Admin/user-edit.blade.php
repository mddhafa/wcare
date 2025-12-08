<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit User - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0fdf4;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 py-5">

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden w-100" style="max-width: 600px;">
        <div class="card-header bg-success text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Edit Data
                @if($user->role_id == 3) Mahasiswa
                @elseif($user->role_id == 2) Psikolog
                @else Admin
                @endif
            </h5>
            <small>ID: {{ $user->user_id }}</small>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.user.update', $user->user_id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- DATA AKUN UTAMA (USERS TABLE) -->
                <h6 class="fw-bold text-success mb-3 border-bottom pb-2">Informasi Akun</h6>

                <div class="mb-3">
                    <label class="form-label fw-medium">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-medium">Password Baru <small class="text-muted fw-normal">(Biarkan kosong jika tidak ingin mengubah)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="******">
                </div>

                <!-- DATA SPESIFIK BERDASARKAN ROLE -->
                @if($user->role_id == 3)
                <!-- FORM KHUSUS MAHASISWA (KORBAN TABLE) -->
                <h6 class="fw-bold text-success mb-3 border-bottom pb-2 pt-2">Data Mahasiswa</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">Umur</label>
                        <input type="number" name="umur" class="form-control"
                            value="{{ old('umur', $user->korban->umur ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">- Pilih -</option>
                            <option value="Laki-laki" {{ (old('jenis_kelamin', $user->korban->jenis_kelamin ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ (old('jenis_kelamin', $user->korban->jenis_kelamin ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                @elseif($user->role_id == 2)
                <!-- FORM KHUSUS PSIKOLOG (PSIKOLOG TABLE) -->
                <h6 class="fw-bold text-success mb-3 border-bottom pb-2 pt-2">Data Profesional</h6>
                <div class="mb-3">
                    <label class="form-label fw-medium">Jadwal Tersedia</label>
                    <input type="datetime-local" name="jadwal_tersedia" class="form-control"
                        value="{{ old('jadwal_tersedia', optional($user->psikolog)->jadwal_tersedia) }}">
                    <div class="form-text">Format: Tanggal dan Jam praktek</div>
                </div>
                @endif

                <!-- BUTTONS -->
                <div class="d-flex justify-content-between mt-5">
                    <a href="{{ url()->previous() }}" class="btn btn-light text-muted border px-4">Batal</a>
                    <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>