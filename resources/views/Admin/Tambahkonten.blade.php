<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Konten Self-Healing - Sistem Curhat</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0fdf4;
      /* Warna Background Hijau Muda */
      color: #334155;
    }

    .main-container {
      padding: 3rem 0;
      min-height: calc(100vh - 70px);
      /* Sisa tinggi setelah navbar */
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* --- CARD STYLE PREMIUM --- */
    .card-custom {
      border: none;
      border-radius: 24px;
      /* Lebih bulat */
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
      background: white;
      overflow: hidden;
      width: 100%;
      max-width: 1100px;
      /* Lebar card */
    }

    .card-header-custom {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      color: white;
      padding: 3rem 2.5rem;
      position: relative;
      overflow: hidden;
    }

    /* Hiasan Background Abstrak */
    .header-decoration {
      position: absolute;
      top: -20px;
      right: -30px;
      font-size: 180px;
      opacity: 0.1;
      transform: rotate(-15deg);
      pointer-events: none;
    }

    /* Tombol Kembali (Bulat Putih) */
    .btn-back-header {
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 50px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      font-size: 0.9rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      backdrop-filter: blur(5px);
      transition: all 0.3s;
    }

    .btn-back-header:hover {
      background-color: white;
      color: #059669;
      transform: translateX(-3px);
    }

    /* Form Styling */
    .form-label {
      font-weight: 600;
      color: #475569;
      margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
      padding: 0.8rem 1.2rem;
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      font-size: 0.95rem;
      transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #059669;
      box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
    }

    /* Upload Box Style */
    .upload-box {
      border: 2px dashed #cbd5e1;
      border-radius: 16px;
      padding: 2rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s;
      background-color: #f8fafc;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .upload-box:hover {
      background-color: #ecfdf5;
      border-color: #059669;
    }

    .upload-icon {
      font-size: 2rem;
      color: #94a3b8;
      margin-bottom: 0.5rem;
      transition: 0.3s;
    }

    .upload-box:hover .upload-icon {
      color: #059669;
      transform: scale(1.1);
    }

    /* Tombol Simpan */
    .btn-simpan {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      border: none;
      color: white;
      padding: 1rem 3rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1rem;
      box-shadow: 0 10px 20px rgba(5, 150, 105, 0.2);
      transition: all 0.3s;
    }

    .btn-simpan:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 25px rgba(5, 150, 105, 0.3);
      background: linear-gradient(135deg, #047857 0%, #064e3b 100%);
    }
  </style>
</head>

<body>

  @include('components.navbar')

  <div class="main-container">
    <div class="container px-4">
      <div class="card card-custom mx-auto">

        <div class="card-header-custom">
          <i class="fa-solid fa-feather-pointed header-decoration"></i>

          <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
            <div class="col-auto">
              <a href="{{ route('admin.dashboard') }}" class="btn-back-header">
                <i class="fa-solid fa-arrow-left"></i> Kembali
              </a>
            </div>
            <div class="col">
              <h2 class="fw-bold mb-1">Tambah Konten Self-Healing</h2>
              <p class="mb-0 opacity-75">Bagikan materi positif berupa Artikel, Video, Audio, atau Gambar.</p>
            </div>
          </div>
        </div>

        <div class="card-body p-4 p-md-5">

          @if ($errors->any())
          <div class="alert alert-danger border-0 border-start border-4 border-danger shadow-sm rounded-3 mb-4">
            <div class="d-flex">
              <i class="fa-solid fa-circle-exclamation fs-4 me-3 mt-1"></i>
              <div>
                <h6 class="fw-bold mb-1">Perhatikan input berikut:</h6>
                <ul class="mb-0 ps-3 small">
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          @endif

          <form action="{{ route('admin.storekontensh') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-5">
              <div class="col-lg-6">
                <div class="mb-4">
                  <label class="form-label">Judul Konten <span class="text-danger">*</span></label>
                  <input type="text" name="judul" class="form-control form-control-lg" placeholder="Contoh: 5 Cara Mengatasi Kecemasan" value="{{ old('judul') }}" required>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label class="form-label">Tipe Konten <span class="text-danger">*</span></label>
                    <select name="jenis_konten" class="form-select" required>
                      <option value="" disabled selected>Pilih...</option>
                      <option value="Artikel" {{ old('jenis_konten') == 'Artikel' ? 'selected' : '' }}>Artikel</option>
                      <option value="Video" {{ old('jenis_konten') == 'Video' ? 'selected' : '' }}>Video</option>
                      <option value="Audio" {{ old('jenis_konten') == 'Audio' ? 'selected' : '' }}>Audio</option>
                      <option value="Foto" {{ old('jenis_konten') == 'Foto' ? 'selected' : '' }}>Gambar</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Target Mood <span class="text-danger">*</span></label>
                    <select name="id_emosi" class="form-select" required>
                      <option value="" disabled selected>Pilih...</option>
                      @foreach ($emosis as $emosi)
                      @php
                      $id = $emosi->id_emosi ?? $emosi->id;
                      $nama = strtolower($emosi->jenis_emosi);
                      $emoji = match(true) {
                      str_contains($nama, 'senang') => '😊',
                      str_contains($nama, 'marah') => '😡',
                      str_contains($nama, 'sedih') => '😢',
                      str_contains($nama, 'takut') => '😨',
                      default => '😐'
                      };
                      @endphp
                      <option value="{{ $id }}" {{ old('id_emosi') == $id ? 'selected' : '' }}>
                        {{ $emoji }} {{ $emosi->jenis_emosi }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="mb-2">
                  <label class="form-label">Link Youtube / Artikel <small class="text-muted fw-normal">(Opsional)</small></label>
                  <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-link"></i></span>
                    <input type="url" name="link_konten" class="form-control border-start-0 ps-0" placeholder="https://..." value="{{ old('link_konten') }}">
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="mb-4">
                  <label class="form-label">Deskripsi Singkat <span class="text-danger">*</span></label>
                  <textarea name="deskripsi" rows="5" class="form-control" placeholder="Tuliskan rangkuman atau isi konten di sini..." required style="resize: none;">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="row g-3">
                  <div class="col-6">
                    <label class="upload-box" onclick="document.getElementById('fileInput').click()">
                      <i class="fa-regular fa-image upload-icon"></i>
                      <span class="fw-bold text-dark small">Upload Cover</span>
                      <span class="text-muted" style="font-size: 0.7rem;">Max 5MB (JPG/PNG)</span>
                      <p id="fileName" class="text-success small fw-bold mt-2 text-break mb-0"></p>
                      <input id="fileInput" name="gambar" type="file" accept="image/*" class="d-none" onchange="previewImage(this)">
                    </label>
                  </div>

                  <div class="col-6">
                    <label class="upload-box" onclick="document.getElementById('audioInput').click()">
                      <i class="fa-solid fa-music upload-icon"></i>
                      <span class="fw-bold text-dark small">Upload Audio</span>
                      <span class="text-muted" style="font-size: 0.7rem;">Max 10MB (MP3)</span>
                      <p id="audioName" class="text-success small fw-bold mt-2 text-break mb-0"></p>
                      <input id="audioInput" name="audio" type="file" accept="audio/*" class="d-none" onchange="previewAudio(this)">
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end align-items-center mt-5 pt-4 border-top">
              <a href="{{ route('admin.dashboard') }}" class="btn btn-light text-muted fw-bold rounded-pill px-4 me-3">Batal</a>
              <button type="submit" class="btn-simpan d-flex align-items-center gap-2">
                <i class="fa-solid fa-paper-plane"></i> Simpan Konten
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @if(session('success'))
  <script>
    function previewImage(input) {
      if (input.files && input.files[0]) {
        document.getElementById('fileName').innerText = input.files[0].name;
      }
    }

    function previewAudio(input) {
      if (input.files && input.files[0]) {
        document.getElementById('audioName').innerText = input.files[0].name;
      }
    }


    Swal.fire({
      title: "Berhasil!",
      text: "{{ session('success') }}",
      icon: "success",
      confirmButtonColor: "#059669",
      confirmButtonText: "Oke, Lanjut",
      timer: 3000
    });
  </script>
  @endif
</body>

</html>