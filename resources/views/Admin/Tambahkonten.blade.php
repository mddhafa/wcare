<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Konten Self-Healing - Sistem Curhat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <!-- Library SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#059669', // Emerald 600
            secondary: '#047857', // Emerald 700
            bgsoft: '#ecfdf5', // Emerald 50
          },
          fontFamily: {
            sans: ['Poppins', 'sans-serif'],
          }
        }
      }
    }
  </script>
</head>

<body class="bg-bgsoft min-h-screen flex flex-col font-sans text-gray-800">

  <!-- NAVBAR SEDERHANA -->
  <header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex-shrink-0 flex items-center">
          <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 text-2xl font-bold text-primary hover:text-secondary transition">
            <i class="fa-solid fa-heart-pulse"></i>
            <span>Sistem Curhat</span>
          </a>
        </div>
        <div class="flex items-center space-x-4">
          @auth
          <div class="hidden md:flex items-center text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
            <i class="fa-regular fa-user mr-2"></i>
            Halo, {{ Auth::user()->name }}
          </div>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm bg-red-100 text-red-600 px-4 py-2 rounded-lg hover:bg-red-200 transition font-medium">
              Logout
            </button>
          </form>
          @endauth
        </div>
      </div>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="flex-grow flex items-center justify-center py-10 px-4 sm:px-6">
    <div class="max-w-2xl w-full">

      <!-- Tombol Kembali -->
      <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-primary transition font-medium">
          <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
      </div>

      <!-- ALERT ERROR (VALIDASI) -->
      @if ($errors->any())
      <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
        <div class="flex">
          <div class="flex-shrink-0">
            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada inputan:</h3>
            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      @endif

      <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Header Card -->
        <div class="bg-primary px-8 py-6 text-white">
          <h2 class="text-2xl font-bold">Tambah Konten Baru</h2>
          <p class="text-emerald-100 text-sm mt-1">Isi formulir di bawah untuk menambahkan materi self-healing.</p>
        </div>

        <!-- Form -->
        <form action="/tambah/selfhealing" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
          @csrf

          <!-- Grid Layout -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Jenis Konten -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Konten</label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                  <i class="fa-solid fa-layer-group"></i>
                </span>
                <input type="text" name="jenis_konten" placeholder="Misal: Artikel / Video" required value="{{ old('jenis_konten') }}"
                  class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition bg-gray-50 focus:bg-white">
              </div>
            </div>

            <!-- Pilih Emosi -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Target Emosi</label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                  <i class="fa-regular fa-face-smile"></i>
                </span>
                <select name="id_emosi" required
                  class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition bg-gray-50 focus:bg-white appearance-none">
                  <option value="" disabled selected>-- Pilih Kategori Emosi --</option>
                  @foreach ($emosis as $emosi)
                  @php
                  $id = $emosi->id_emosi ?? $emosi->id;
                  $nama = strtolower($emosi->jenis_emosi);
                  $emoji = '';
                  if (str_contains($nama, 'senang')) $emoji = '😊';
                  elseif (str_contains($nama, 'marah')) $emoji = '😡';
                  elseif (str_contains($nama, 'sedih')) $emoji = '😢';
                  elseif (str_contains($nama, 'takut')) $emoji = '😨';
                  @endphp
                  <option value="{{ $id }}" {{ old('id_emosi') == $id ? 'selected' : '' }}>
                    {{ $emoji }} {{ $emosi->jenis_emosi }}
                  </option>
                  @endforeach
                </select>
                <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                  <i class="fa-solid fa-chevron-down text-xs"></i>
                </span>
              </div>
            </div>
          </div>

          <!-- Judul -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Konten</label>
            <input type="text" name="judul" placeholder="Masukkan judul yang menarik..." required value="{{ old('judul') }}"
              class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition bg-gray-50 focus:bg-white">
          </div>

          <!-- Link Konten -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Link Sumber (Opsional)</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fa-solid fa-link"></i>
              </span>
              <input type="url" name="link_konten" placeholder="https://youtube.com/..." value="{{ old('link_konten') }}"
                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition bg-gray-50 focus:bg-white">
            </div>
          </div>

          <!-- Deskripsi -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat</label>
            <textarea name="deskripsi" rows="4" placeholder="Jelaskan isi konten ini secara singkat..."
              class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition bg-gray-50 focus:bg-white resize-none">{{ old('deskripsi') }}</textarea>
          </div>

          <!-- Upload Gambar -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Sampul</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition cursor-pointer" onclick="document.getElementById('fileInput').click()">
              <div class="space-y-1 text-center">
                <i class="fa-regular fa-image text-4xl text-gray-400"></i>
                <div class="flex text-sm text-gray-600 justify-center">
                  <label class="relative cursor-pointer rounded-md font-medium text-primary hover:text-secondary focus-within:outline-none">
                    <span>Upload file</span>
                    <input id="fileInput" name="gambar" type="file" accept="image/*" class="sr-only" onchange="previewImage(this)">
                  </label>
                  <p class="pl-1">atau drag & drop</p>
                </div>
                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                <p id="fileName" class="text-sm font-medium text-primary mt-2"></p>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="pt-4">
            <button type="submit" class="w-full bg-primary text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:bg-secondary focus:outline-none focus:ring-4 focus:ring-green-300 transition transform hover:-translate-y-1">
              <i class="fa-solid fa-save mr-2"></i> Simpan Konten
            </button>
          </div>

        </form>
      </div>
    </div>
  </main>

  <script>
    // Preview Image
    function previewImage(input) {
      if (input.files && input.files[0]) {
        var fileName = input.files[0].name;
        document.getElementById('fileName').innerText = "File terpilih: " + fileName;
      }
    }

    // Logic SweetAlert (Notifikasi Sukses)
    @if(session('success'))
    Swal.fire({
      title: "Berhasil!",
      text: "{{ session('success') }}",
      icon: "success",
      confirmButtonColor: "#059669",
      confirmButtonText: "Oke, Lanjut"
    });
    @endif
  </script>

</body>

</html>