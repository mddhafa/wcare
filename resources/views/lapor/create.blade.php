<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Laporan - Sistem Curhat</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #059669;
            --primary-hover: #047857;
            --bg-soft: #ecfdf5;
            --text-dark: #1f2937;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-soft);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-section {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 3rem 0;
        }

        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px -10px rgba(5, 150, 105, 0.15);
            background: #ffffff;
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 2rem;
            text-align: center;
            border-bottom: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(5, 150, 105, 0.2);
        }

        .input-group-text {
            background-color: #f3f4f6;
            border-right: none;
            color: var(--primary-color);
        }

        .form-control,
        .form-select {
            border-left: none;
        }

        .custom-input {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .btn-submit {
            background-color: var(--primary-color);
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(4, 120, 87, 0.3);
        }

        .btn-cancel {
            background-color: #f3f4f6;
            color: #4b5563;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            width: 100%;
        }

        .btn-cancel:hover {
            background-color: #e5e7eb;
            color: #1f2937;
        }

        .privacy-note {
            font-size: 0.85rem;
            color: #6b7280;
            background: #f9fafb;
            padding: 1rem;
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9">

                    <div class="card card-custom">
                        <div class="card-header-custom">
                            <i class="bi bi-shield-check display-4 mb-2"></i>
                            <h3 class="fw-bold mb-1">Buat Laporan Baru</h3>
                            <p class="mb-0 opacity-75 fw-light">Ruang aman untuk menceritakan pengalaman Anda.</p>
                        </div>

                        <div class="card-body p-4 p-md-5">
                            <form action="{{ route('lapor.store') }}" method="POST">
                                @csrf

                                <h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Detail Kejadian</h6>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="jenis" class="form-label fw-medium small">Jenis Laporan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="bi bi-exclamation-triangle"></i></span>
                                            <select name="jenis" id="jenis" class="form-select custom-input border-start-0 rounded-end-3" required>
                                                <option value="" selected disabled>Pilih Jenis Laporan</option>
                                                <option value="Kekerasan">Kekerasan</option>
                                                <option value="Diskriminasi">Diskriminasi</option>
                                                <option value="Pelecehan">Pelecehan</option>
                                                <option value="Bullying">Bullying</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tanggal" class="form-label fw-medium small">Tanggal Kejadian</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="bi bi-calendar-event"></i></span>
                                            <input type="date" name="tanggal" id="tanggal" class="form-control custom-input border-start-0 rounded-end-3" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="lokasi" class="form-label fw-medium small">Lokasi Kejadian</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="bi bi-geo-alt"></i></span>
                                            <input type="text" name="lokasi" id="lokasi" class="form-control custom-input border-start-0 rounded-end-3" placeholder="Contoh: Di lingkungan kampus, Gedung B..." required>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4 text-muted opacity-25">

                                <h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Kronologi Lengkap</h6>

                                <div class="mb-4">
                                    <textarea name="kronologi" id="kronologi" rows="6" class="form-control custom-input" placeholder="Ceritakan apa yang terjadi sedetail mungkin. Identitas Anda aman bersama kami..." required></textarea>
                                </div>

                                <div class="privacy-note mb-4 d-flex align-items-start">
                                    <i class="bi bi-lock-fill me-2 mt-1"></i>
                                    <div>
                                        <strong>Privasi Dijamin.</strong>
                                        <br>Laporan Anda akan ditangani secara rahasia oleh tim konselor kami.
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <a href="{{ url('/dashboard') }}" class="btn btn-cancel">
                                            <i class="bi bi-arrow-left me-1"></i> Kembali
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-submit text-white">
                                            Kirim Laporan <i class="bi bi-send-fill ms-1"></i>
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-4 text-muted small">
                        &copy; {{ date('Y') }} Sistem Curhat & Pelaporan.
                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            title: "Laporan Terkirim!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: "#059669",
            confirmButtonText: "Baik, Terima Kasih"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('/dashboard') }}";
            }
        });
    </script>
    @endif
</body>

</html>