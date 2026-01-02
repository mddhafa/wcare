<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Psikolog - Sistem Curhat</title>

    {{-- Load Vite & Resources --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-color: #059669;
            --primary-dark: #047857;
            --primary-light: #d1fae5;
            --text-dark: #1f2937;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 70px;
        }

        main {
            flex: 1;
            padding: 2rem 0;
        }

        .hero-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 20px;
            padding: 2.5rem 2.5rem;
            border: none;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px -5px rgba(5, 150, 105, 0.2);
            margin-bottom: 2.5rem;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .hero-title {
            font-weight: 700;
            font-size: 2rem;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        .hero-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 600px;
            line-height: 1.5;
        }

        .status-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            padding: 0.8rem 1.2rem;
            display: inline-block;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .action-card {
            background: white;
            border-radius: 16px;
            border: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
            padding: 2rem 1.8rem;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .card-laporan {
            border-top: 4px solid #dc3545;
        }

        .card-chat {
            border-top: 4px solid #0d6efd;
        }

        .card-arsip {
            border-top: 4px solid #198754;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            transition: all 0.3s ease;
        }

        .card-laporan .icon-wrapper {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05));
            color: #dc3545;
        }

        .card-chat .icon-wrapper {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.1), rgba(13, 110, 253, 0.05));
            color: #0d6efd;
        }

        .card-arsip .icon-wrapper {
            background: linear-gradient(135deg, rgba(25, 135, 84, 0.1), rgba(25, 135, 84, 0.05));
            color: #198754;
        }

        .card-tag {
            background: rgba(0, 0, 0, 0.03);
            color: #64748b;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            display: inline-block;
        }

        .card-content {
            flex: 1;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 0.8rem;
            color: #1e293b;
        }

        .card-description {
            color: #64748b;
            line-height: 1.5;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .button-container {
            margin-top: auto;
            min-height: 50px;
            display: flex;
            align-items: flex-end;
        }

        .btn-action {
            border-radius: 10px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            border: none;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-laporan {
            background: linear-gradient(135deg, #dc3545, #ff6b6b);
            color: white;
        }

        .btn-chat {
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
            color: white;
        }

        .btn-arsip {
            background: linear-gradient(135deg, #198754, #40c057);
            color: white;
        }

        .quote-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            border: none;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
            border-left: 5px solid var(--primary-color);
        }

        .quote-content {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .quote-icon {
            color: var(--primary-color);
            font-size: 1.8rem;
            flex-shrink: 0;
            margin-top: 0.2rem;
        }

        .quote-text h6 {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .quote-text p {
            color: #64748b;
            font-style: italic;
            margin-bottom: 0;
            line-height: 1.6;
        }

        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .alert-container {
            position: relative;
            z-index: 100;
        }

        /* TOAST NOTIFICATION */
        #toastContainer {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 9999;
        }

        .toast-notification {
            background: white;
            padding: 16px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-left: 4px solid var(--primary-color);
            margin-bottom: 10px;
            min-width: 300px;
            animation: slideIn 0.3s ease;
            cursor: pointer;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @media (max-width: 992px) {
            .hero-card {
                padding: 2rem 1.5rem;
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .action-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            main {
                padding: 1.5rem 0;
            }

            .action-card {
                padding: 1.5rem;
            }

            .icon-wrapper {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="fixed-top bg-white shadow-sm">
        @include('components.navbar')
    </div>

    <main>
        <div class="container">

            {{-- Flash Messages --}}
            <div class="alert-container">
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Perhatian!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>

            <div class="hero-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="hero-content">
                            <div class="hero-badge">
                                <i class="bi bi-patch-check-fill"></i> Psikolog Profesional
                            </div>
                            <h1 class="hero-title">Selamat Datang, {{ Auth::user()->name }}</h1>
                            <p class="hero-subtitle">Siap memberikan bimbingan dan dukungan untuk mahasiswa yang membutuhkan.</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="status-badge">
                            <div class="d-flex align-items-center justify-content-center justify-content-md-end gap-2 mb-1">
                                <i class="bi bi-circle-fill text-success"></i> <span class="fw-bold">Siap Melayani</span>
                            </div>
                            <p class="mb-0 text-white text-opacity-75 small">Status: Aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-grid">
                <div class="action-card card-laporan">
                    <div class="card-header">
                        <div class="icon-wrapper"><i class="bi bi-inbox-fill"></i></div>
                        <span class="card-tag">PRIORITAS</span>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Laporan Masuk</h4>
                        <p class="card-description">Tinjau keluhan mahasiswa yang membutuhkan penanganan segera.</p>
                    </div>
                    <div class="button-container">
                        <a href="{{ route('lapor.index') }}" class="btn-action btn-laporan stretched-link">
                            Buka Laporan <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="action-card card-chat">
                    <div class="card-header">
                        <div class="icon-wrapper"><i class="bi bi-chat-dots-fill"></i></div>
                        <span class="card-tag">ONLINE</span>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Ruang Konsultasi</h4>
                        <p class="card-description">Berikan konseling langsung melalui chat real-time.</p>
                    </div>
                    <div class="button-container">
                        <a href="{{ route('psikolog.chat') }}" class="btn-action btn-chat stretched-link">
                            Mulai Chat <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="action-card card-arsip">
                    <div class="card-header">
                        <div class="icon-wrapper"><i class="bi bi-archive-fill"></i></div>
                        <span class="card-tag">ARSIP</span>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Arsip Selesai</h4>
                        <p class="card-description">Lihat kembali riwayat kasus yang telah berhasil ditangani.</p>
                    </div>
                    <div class="button-container">
                        <a href="{{ route('lapor.arsip') }}" class="btn-action btn-arsip stretched-link">
                            Lihat Arsip <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="quote-card">
                <div class="quote-content">
                    <div class="quote-icon"><i class="bi bi-lightbulb-fill"></i></div>
                    <div class="quote-text">
                        <h6>Inspirasi Hari Ini</h6>
                        <p>"Menjadi pendengar yang baik adalah langkah pertama dalam menyembuhkan luka yang tak terlihat. Setiap percakapan adalah kesempatan untuk membuat perbedaan."</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    @include('components.footer')

    {{-- CONTAINER TOAST --}}
    <div id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- REALTIME NOTIFICATION LOGIC --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.action-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });

            const audioContext = new(window.AudioContext || window.webkitAudioContext)();

            function playNotificationSound() {
                if (audioContext.state === 'suspended') audioContext.resume();
                const o = audioContext.createOscillator();
                const g = audioContext.createGain();
                o.connect(g);
                g.connect(audioContext.destination);
                o.frequency.value = 1000;
                g.gain.setValueAtTime(0.1, audioContext.currentTime);
                g.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.5);
                o.start();
                o.stop(audioContext.currentTime + 0.5);
            }

            const toastContainer = document.getElementById('toastContainer');

            function showToast(title, message) {
                const toast = document.createElement('div');
                toast.className = 'toast-notification';
                toast.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-success rounded-circle p-2 text-white d-flex align-items-center justify-content-center" style="width:32px;height:32px">
                            <i class="bi bi-chat-dots-fill" style="font-size:0.8rem"></i>
                        </div>
                        <div class="overflow-hidden">
                            <strong class="d-block text-dark text-truncate" style="font-size:0.9rem">${title}</strong>
                            <small class="text-muted text-truncate d-block" style="max-width: 250px;">${message}</small>
                        </div>
                    </div>
                `;
                toast.onclick = () => window.location.href = "{{ route('psikolog.chat') }}";

                toastContainer.appendChild(toast);
                setTimeout(() => {
                    toast.style.transform = 'translateX(0)';
                    toast.style.opacity = '1';
                }, 10);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }, 4000);
            }

            const psikologId = "{{ Auth::user()->user_id }}";

            document.body.addEventListener('click', () => {
                if (audioContext.state === 'suspended') audioContext.resume();
            }, {
                once: true
            });

            if (typeof Echo !== "undefined") {
                window.Echo.private(`chat.user.${psikologId}`)
                    .listen('.message.sent', (e) => {
                        console.log("Pesan Baru di Dashboard:", e);
                        playNotificationSound();

                        const senderName = "Pesan Baru";
                        showToast(senderName, e.chat.message);
                    });
            }
        });
    </script>
</body>

</html>