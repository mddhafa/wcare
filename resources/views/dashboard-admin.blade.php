<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Sistem Curhat</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

  <!-- SIDEBAR -->
  <aside class="w-64 bg-white shadow-md h-screen p-5 fixed">
    <h2 class="text-2xl font-bold text-blue-700 mb-8">Admin Panel</h2>

    <nav class="space-y-3">
      <a href="/dashboard" class="block py-2 px-3 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">
        🏠 Dashboard
      </a>
      <a href="/admin/users" class="block py-2 px-3 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">
        👥 Kelola Pengguna
      </a>
      <a href="/admin/reports" class="block py-2 px-3 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">
        📝 Laporan Curhat
      </a>
      <a href="/admin/psikolog" class="block py-2 px-3 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">
        🧠 Data Psikolog
      </a>
      <a href="/admin/settings" class="block py-2 px-3 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">
        ⚙️ Pengaturan
      </a>
      <a href="/tambah/selfhealing" class="block py-2 px-3 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">
        📚 Tambah Konten Self-Healing
      </a>
      <a href="/selfhealing" class="block py-2 px-3 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">
        🦾 Konten Self-Healing
      </a>
    </nav>

    <div class="absolute bottom-5 left-0 right-0 px-5">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition">
          Logout
        </button>
      </form>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="ml-64 p-8 flex-1">
    <header class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-blue-700">Dashboard Admin</h1>
        <p class="text-gray-600">Halo, {{ Auth::user()->name }} </p>
      </div>
      <div class="bg-white px-4 py-2 rounded-lg shadow text-gray-600">
        Role: <strong>{{ Auth::user()->role->name ?? 'Admin' }}</strong>
      </div>
    </header>

    <!-- STATISTIK -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
      <div class="bg-white p-6 rounded-xl shadow text-center">
        <h3 class="text-gray-500 text-sm font-medium">Jumlah Pengguna</h3>
        <p class="text-3xl font-bold text-blue-700 mt-2">{{ $userCount ?? 0 }}</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow text-center">
        <h3 class="text-gray-500 text-sm font-medium">Total Laporan</h3>
        <p class="text-3xl font-bold text-blue-700 mt-2">{{ $reportCount ?? 0 }}</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow text-center">
        <h3 class="text-gray-500 text-sm font-medium">Psikolog Terdaftar</h3>
        <p class="text-3xl font-bold text-blue-700 mt-2">{{ $psychologistCount ?? 0 }}</p>
      </div>
    </section>

    <!-- TABEL LAPORAN -->
    <section class="bg-white p-6 rounded-xl shadow">
      <h2 class="text-xl font-semibold mb-4 text-gray-700">Laporan Terbaru</h2>
      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-gray-100 text-gray-700 text-left">
            <th class="py-2 px-4 border-b">#</th>
            <th class="py-2 px-4 border-b">Nama Pengguna</th>
            <th class="py-2 px-4 border-b">Kategori</th>
            <th class="py-2 px-4 border-b">Tanggal</th>
            <th class="py-2 px-4 border-b text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($laporan ?? [] as $item)
            <tr class="border-b hover:bg-gray-50">
              <td class="py-2 px-4">{{ $loop->iteration }}</td>
              <td class="py-2 px-4">{{ $item->user->name ?? '-' }}</td>
              <td class="py-2 px-4">{{ $item->kategori ?? '-' }}</td>
              <td class="py-2 px-4">{{ $item->created_at->format('d M Y') }}</td>
              <td class="py-2 px-4 text-center">
                <a href="{{ route('laporan.show', $item->id) }}" class="text-blue-600 hover:underline">Lihat</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-4 text-gray-500">Belum ada laporan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </section>
  </main>

</body>
</html>
