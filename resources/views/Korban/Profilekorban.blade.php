<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

@include('components.navbar')

<div class="container my-5">

    <h2 class="mb-4 text-center">Profil Anda</h2>

    <!-- Flash message sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(!$profile)
        <div class="alert alert-warning text-center">
            Profil belum dibuat.
        </div>

        <div class="text-center">
            <a href="{{ url('/profile/korban/add') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Profil
            </a>
        </div>

    @else
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Data Profil</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $profile->name }}</p>
                <p><strong>Umur:</strong> {{ $profile->umur }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ $profile->jenis_kelamin }}</p>
                <p><strong>Email:</strong> {{ $profile->email }}</p>
            </div>
            <div class="card-footer text-end">
                <a href="" class="btn btn-secondary btn-sm">
                    <i class="bi bi-pencil-square"></i> Edit Profil
                </a>
            </div>
        </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
