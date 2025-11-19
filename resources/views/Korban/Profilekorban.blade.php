<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            padding: 20px;
        }
        .container {
            width: 500px;
            margin: auto;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .btn {
            padding: 8px 15px;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-primary {
            background: #007bff;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .alert {
            padding: 10px;
            background: #f6d365;
            margin-bottom: 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Profil Anda</h2>

    <!-- Tampilkan flash message sukses -->
    @if(session('success'))
        <div class="alert" style="background:#d4edda;color:#155724;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Jika profil belum ada -->
    @if(!$profile)
        <div class="alert">
            Profil belum dibuat.
        </div>

        <a href="/profile/korban/add" class="btn btn-primary">Tambah Profil</a>

    <!-- Jika profil sudah ada -->
    @else
        <div class="card">
            <h3>Data Profil</h3>
            <p><strong>Nama:</strong> {{ $profile->name }}</p>
            <p><strong>Umur:</strong> {{ $profile->umur }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ $profile->jenis_kelamin }}</p>
            <p><strong>Email:</strong> {{ $profile->email }}</p>
        </div>

        <!-- Tombol edit profil (opsional) -->
    @endif

</div>

</body>
</html>
