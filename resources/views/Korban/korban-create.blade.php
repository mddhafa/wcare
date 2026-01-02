<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Profil Korban</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            padding: 20px;
        }

        .container {
            width: 500px;
            margin: auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        .btn {
            padding: 8px 15px;
            margin-top: 10px;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-success {
            background: #28a745;
        }

        .btn-secondary {
            background: #6c757d;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Tambah Profil Korban</h2>

        <form action="/profile/korban/add" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Umur:</label>
                <input type="number" name="umur" required>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin:</label>
                <select name="jenis_kelamin" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('korban.profilekorban') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>

</body>

</html>