<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Psikolog</title>

    <!-- Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body style="font-family: 'Poppins', sans-serif;" class="bg-light">

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- Hero Section - Clean & Minimal -->
    <div class=" border-bottom mt-5 py-5" style="background-color: whitesmoke;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-6 fw-bold text-dark mb-2">
                        Tim Psikolog Profesional
                    </h1>
                    <p class="lead text-muted mb-0">
                        Temukan psikolog yang tepat untuk kebutuhan konsultasi Anda
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="d-inline-flex align-items-center gap-2 bg-success bg-opacity-10 text-success px-4 py-3 rounded-pill">
                        <i class="bi bi-people-fill fs-4"></i>
                        <div class="text-start">
                            <div class="fw-bold fs-10">{{ count($psikolog) }}</div>
                            <small class="opacity-75">Tersedia</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <!-- Search Box - Modern Design -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-lg-6">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute text-muted" style="left: 20px; top: 50%; transform: translateY(-50%); font-size: 18px;"></i>
                    <input type="text"
                        class="form-control form-control-lg border-0 shadow-sm ps-5 pe-4 rounded-pill"
                        placeholder="Cari nama atau email psikolog..."
                        id="searchInput"
                        style="background-color: white;">
                </div>
            </div>
        </div>

        <!-- Cards Grid - Clean Layout -->
        <div class="row g-4" id="psikologGrid">
            @foreach($psikolog as $p)
            <div class="col-12 col-md-6 col-lg-4"
                data-name="{{ strtolower($p->name) }}"
                data-email="{{ strtolower($p->email) }}">

                <div class="card border-0 h-100 shadow-sm rounded-4 overflow-hidden" style="transition: all 0.3s ease;">
                    <!-- Avatar Header -->
                    <div class="card-header bg-white border-0 text-center pt-4 pb-3">
                        <div class="mx-auto rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-person-circle text-success" style="font-size: 48px;"></i>
                        </div>
                    </div>

                    <div class="card-body text-center px-4 pb-4">
                        <!-- Name -->
                        <h5 class="fw-bold mb-2">{{ $p->name }}</h5>

                        <!-- Role Badge -->
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1 mb-3">
                            <i class="bi bi-star-fill me-1" style="font-size: 10px;"></i>
                            Psikolog Profesional
                        </span>

                        <!-- Email -->
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-4 text-muted small">
                            <i class="bi bi-envelope"></i>
                            <span class="text-truncate">{{ $p->email }}</span>
                        </div>

                        <!-- Button -->
                        <a href="{{ route('chat.psikolog', $p->user_id) }}"
                            class="btn btn-success w-100 rounded-pill">
                            <i class="bi bi-chat-dots me-2"></i>
                            Mulai Konsultasi
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="text-center py-5 d-none">
            <div class="mb-3">
                <i class="bi bi-inbox text-muted" style="font-size: 64px; opacity: 0.3;"></i>
            </div>
            <h5 class="text-muted fw-normal">Tidak ada psikolog ditemukan</h5>
            <p class="text-muted small">Coba kata kunci pencarian yang berbeda</p>
        </div>
    </div>

    <!-- FOOTER -->
    @include('components.footer')

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Search Functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('#psikologGrid > div');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const email = card.getAttribute('data-email');

                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    card.classList.remove('d-none');
                    visibleCount++;
                } else {
                    card.classList.add('d-none');
                }
            });

            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            if (visibleCount === 0) {
                noResults.classList.remove('d-none');
            } else {
                noResults.classList.add('d-none');
            }
        });

        // Hover effect for cards
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>

</html>