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

    <style>
        /* Toast Notification Container */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            pointer-events: none;
        }

        .toast-notification {
            pointer-events: auto;
            min-width: 320px;
            max-width: 420px;
            margin-bottom: 12px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            animation: slideInRight 0.3s ease-out;
            background: white;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .toast-notification:hover {
            transform: translateX(-5px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
        }

        .toast-notification.hiding {
            animation: slideOutRight 0.3s ease-out forwards;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        /* Notification Badge on Cards */
        .notification-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 12px;
            animation: pulse 1.5s ease-in-out infinite;
            z-index: 10;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.1);
            }
        }

        /* Sound Toggle Button - Floating */
        .sound-toggle-fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #198754, #20c997);
            border: none;
            border-radius: 50%;
            box-shadow: 0 6px 20px rgba(25, 135, 84, 0.4);
            color: white;
            font-size: 22px;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sound-toggle-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 28px rgba(25, 135, 84, 0.5);
        }

        .sound-toggle-fab:active {
            transform: scale(0.95);
        }

        .sound-toggle-fab.muted {
            background: linear-gradient(135deg, #6c757d, #adb5bd);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }

        @media (max-width: 576px) {
            .toast-container {
                left: 20px;
                right: 20px;
            }

            .toast-notification {
                min-width: auto;
                width: 100%;
            }

            .sound-toggle-fab {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }
    </style>
</head>

<body style="font-family: 'Poppins', sans-serif;" class="bg-light">

    <!-- NAVBAR -->
    @include('components.navbar')

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Sound Toggle FAB -->
    <button class="sound-toggle-fab" id="soundToggleFab" title="Toggle Notifikasi Suara">
        <i class="bi bi-bell-fill"></i>
    </button>

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
                data-email="{{ strtolower($p->email) }}"
                data-psikolog-id="{{ $p->user_id }}">

                <div class="card border-0 h-100 shadow-sm rounded-4 overflow-hidden position-relative" style="transition: all 0.3s ease;">

                    <!-- Notification Badge (Hidden by default) -->
                    <span class="notification-badge" data-badge-for="{{ $p->user_id }}" style="display: none;">
                        <i class="bi bi-chat-dots-fill me-1"></i>Pesan Baru
                    </span>

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
    @foreach($psikolog as $p)
    <script>
        // ===========================
        // STATE VARIABLES
        // ===========================
        const toastContainer = document.getElementById('toastContainer');
        const soundToggleFab = document.getElementById('soundToggleFab');
        const currentUserId = "{{ Auth::id() }}";

        let notificationSound = true;
        let audioContext = null;
        let globalLastMessageIds = new Set();
        let pollInterval = null;
        let isPageVisible = true;

        // Store psikolog data for easy lookup
        const psikologData = new Map();

        psikologData.set("{{ $p->user_id }}", {
            name: "{{ $p->name }}",
            email: "{{ $p->email }}"
        });


        // ===========================
        // AUDIO CONTEXT
        // ===========================
        function initAudioContext() {
            if (!audioContext) {
                audioContext = new(window.AudioContext || window.webkitAudioContext)();
            }
            return audioContext;
        }

        // ===========================
        // NOTIFICATION SOUND
        // ===========================
        function playNotificationSound() {
            if (!notificationSound) return;

            const context = initAudioContext();
            const oscillator = context.createOscillator();
            const gainNode = context.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(context.destination);

            oscillator.frequency.value = 800;
            oscillator.type = "sine";

            gainNode.gain.setValueAtTime(0.3, context.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(
                0.01,
                context.currentTime + 0.3
            );

            oscillator.start(context.currentTime);
            oscillator.stop(context.currentTime + 0.3);
        }

        // ===========================
        // SOUND TOGGLE
        // ===========================
        soundToggleFab.addEventListener('click', function() {
            notificationSound = !notificationSound;
            const icon = this.querySelector('i');

            if (notificationSound) {
                icon.className = 'bi bi-bell-fill';
                this.classList.remove('muted');
                showToast('Notifikasi suara diaktifkan', null, 'success');
            } else {
                icon.className = 'bi bi-bell-slash-fill';
                this.classList.add('muted');
                showToast('Notifikasi suara dinonaktifkan', null, 'info');
            }
        });

        // ===========================
        // TOAST NOTIFICATION
        // ===========================
        function showToast(message, psikologName = null, type = 'warning') {
            const toast = document.createElement('div');
            toast.className = 'toast-notification';

            const bgColor = type === 'success' ? '#d4edda' :
                type === 'info' ? '#d1ecf1' :
                type === 'warning' ? '#fff3cd' : '#f8d7da';

            const iconColor = type === 'success' ? '#155724' :
                type === 'info' ? '#0c5460' :
                type === 'warning' ? '#856404' : '#721c24';

            const icon = type === 'success' ? 'check-circle-fill' :
                type === 'info' ? 'info-circle-fill' :
                type === 'warning' ? 'chat-dots-fill' : 'exclamation-triangle-fill';

            toast.innerHTML = `
                <div class="d-flex align-items-center p-3 border-start border-4" style="border-color: ${iconColor} !important; background-color: ${bgColor};">
                    <i class="bi bi-${icon} me-3" style="font-size: 1.5rem; color: ${iconColor};"></i>
                    <div class="flex-grow-1">
                        ${psikologName ? `<strong class="d-block">${psikologName}</strong>` : ''}
                        <span class="small">${message}</span>
                    </div>
                    <button class="btn-close btn-sm ms-2" onclick="this.closest('.toast-notification').remove()"></button>
                </div>
            `;

            // Make toast clickable to navigate to chat
            if (psikologName && type === 'warning') {
                toast.style.cursor = 'pointer';
                toast.addEventListener('click', function(e) {
                    if (!e.target.classList.contains('btn-close')) {
                        // Find psikolog ID by name
                        for (let [id, data] of psikologData) {
                            if (data.name === psikologName) {
                                window.location.href = `/chat/psikolog/${id}`;
                                break;
                            }
                        }
                    }
                });
            }

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 300);
            }, 6000);
        }

        // ===========================
        // BROWSER NOTIFICATION
        // ===========================
        function requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
        }

        function showBrowserNotification(psikologName, message) {
            if ('Notification' in window && Notification.permission === 'granted') {
                const notification = new Notification(`Pesan Baru dari ${psikologName}`, {
                    body: message,
                    icon: '/favicon.ico',
                    badge: '/favicon.ico',
                    tag: `chat-${psikologName}`,
                    renotify: true,
                });

                notification.onclick = function() {
                    window.focus();
                    // Find psikolog ID by name
                    for (let [id, data] of psikologData) {
                        if (data.name === psikologName) {
                            window.location.href = `/chat/psikolog/${id}`;
                            break;
                        }
                    }
                    notification.close();
                };
            }
        }

        // ===========================
        // NOTIFICATION BADGE
        // ===========================
        function showNotificationBadge(psikologId) {
            const badge = document.querySelector(`[data-badge-for="${psikologId}"]`);
            if (badge) {
                badge.style.display = 'block';
            }
        }

        function hideNotificationBadge(psikologId) {
            const badge = document.querySelector(`[data-badge-for="${psikologId}"]`);
            if (badge) {
                badge.style.display = 'none';
            }
        }

        // ===========================
        // PAGE VISIBILITY TRACKING
        // ===========================
        document.addEventListener('visibilitychange', function() {
            isPageVisible = !document.hidden;
        });

        // ===========================
        // CHECK ALL PSIKOLOG FOR NEW MESSAGES
        // ===========================
        async function checkAllPsikologForNewMessages() {
            const psikologIds = Array.from(psikologData.keys());

            for (const psikologId of psikologIds) {
                try {
                    const response = await fetch(`/chat/refresh/${psikologId}`);
                    const data = await response.json();

                    if (!data.messages || data.messages.length === 0) continue;

                    // Check for new incoming messages from this psikolog
                    data.messages.forEach(msg => {
                        const messageId = msg.id.toString();

                        // If message is new and from psikolog (not from current user)
                        if (!globalLastMessageIds.has(messageId) && msg.sender_id != currentUserId) {
                            const psikolog = psikologData.get(psikologId);

                            // Show notifications
                            playNotificationSound();
                            showToast(msg.message, psikolog.name, 'warning');
                            showBrowserNotification(psikolog.name, msg.message);

                            // Show badge on card
                            showNotificationBadge(psikologId);

                            // Update page title if not visible
                            if (!isPageVisible) {
                                document.title = '🔔 Pesan Baru - Daftar Psikolog';
                            }
                        }

                        globalLastMessageIds.add(messageId);
                    });
                } catch (err) {
                    console.error(`Error checking messages from psikolog ${psikologId}:`, err);
                }
            }
        }

        // ===========================
        // INITIALIZE MESSAGE TRACKING
        // ===========================
        async function initializeMessageTracking() {
            const psikologIds = Array.from(psikologData.keys());

            console.log('🔄 Initializing message tracking...');

            for (const psikologId of psikologIds) {
                try {
                    const response = await fetch(`/chat/refresh/${psikologId}`);
                    const data = await response.json();

                    if (data.messages) {
                        data.messages.forEach(msg => {
                            globalLastMessageIds.add(msg.id.toString());
                        });
                    }
                } catch (err) {
                    console.error(`Error initializing psikolog ${psikologId}:`, err);
                }
            }

            console.log('✅ Message tracking initialized');

            // Start polling after initialization
            pollInterval = setInterval(checkAllPsikologForNewMessages, 5000);
        }

        // ===========================
        // CLEANUP ON PAGE UNLOAD
        // ===========================
        window.addEventListener('beforeunload', function() {
            if (pollInterval) clearInterval(pollInterval);
        });

        // Reset title when page becomes visible
        window.addEventListener('focus', function() {
            document.title = 'Daftar Psikolog';
        });

        // ===========================
        // SEARCH FUNCTIONALITY
        // ===========================
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

        // ===========================
        // CARD HOVER EFFECT
        // ===========================
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // ===========================
        // INITIALIZE ON PAGE LOAD
        // ===========================
        requestNotificationPermission();

        if (psikologData.size > 0) {
            initializeMessageTracking();
        } else {
            console.log('⚠️ No psikolog found');
        }

        console.log('✅ Notification system initialized');
    </script>
    @endforeach
</body>

</html>