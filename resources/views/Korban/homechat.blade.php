<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Saya</title>

    {{-- Load Vite untuk Realtime --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --card-bg: #ffffff;
            --navbar-height: 70px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
            padding-top: var(--navbar-height);
        }

        .navbar-fixed-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 1rem;
            margin-bottom: 0;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
            margin-bottom: 15px;
        }

        .back-button:hover {
            background: var(--primary);
            color: white;
            transform: translateX(-3px);
        }

        .chat-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .chat-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .chat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            border-color: var(--primary);
        }

        .chat-card.new-msg {
            background-color: #f0fdf4;
            border-left: 5px solid var(--primary);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .avatar-container {
            position: relative;
        }

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-dot {
            position: absolute;
            bottom: -4px;
            right: -4px;
            width: 16px;
            height: 16px;
            background: #9ca3af;
            border: 2px solid white;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .status-dot.online {
            background: #10b981;
            animation: pulse-green 2s infinite;
        }

        .psikolog-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .psikolog-title {
            color: var(--primary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .last-message {
            background: #f8fafc;
            border-radius: 10px;
            padding: 12px;
            margin: 15px 0;
            border: 1px solid #e5e7eb;
            min-height: 80px;
        }

        .last-message-label {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 4px;
            display: block;
        }

        .last-message-text {
            font-size: 0.9rem;
            color: #374151;
            line-height: 1.4;
            margin-bottom: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .action-button {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
            text-decoration: none;
            margin-top: auto;
        }

        .action-button:hover {
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 3rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .waiting-badge {
            display: inline-block;
            padding: 8px 20px;
            background: #f3f4f6;
            color: #6b7280;
            border-radius: 50px;
            font-weight: 500;
            border: 1px solid #e5e7eb;
        }

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
            border-left: 4px solid var(--primary);
            margin-bottom: 10px;
            min-width: 300px;
            max-width: 350px;
            animation: slideIn 0.3s ease;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .toast-notification:hover {
            transform: translateY(-3px);
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .toast-avatar {
            width: 40px;
            height: 40px;
            min-width: 40px;
            min-height: 40px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
            border: 1px solid #e5e7eb;
            flex-shrink: 0;
        }

        .notification-sound-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
            border: 1px solid #e5e7eb;
            background: white;
        }

        .notification-sound-btn:hover {
            background: #f1f5f9;
        }

        /* Animation */
        @keyframes pulse-green {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }
    </style>
</head>

<body>

    {{-- FIXED NAVBAR --}}
    <div class="navbar-fixed-wrapper">
        @include('components.navbar')
    </div>

    {{-- TOAST CONTAINER --}}
    <div id="toastContainer"></div>

    <div class="main-container">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="back-button mb-0">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                {{-- TOMBOL SOUND --}}
                <div class="notification-sound-btn" id="soundToggle" title="Toggle Suara Notifikasi">
                    <i class="bi bi-bell-fill text-success"></i>
                </div>
            </div>

            <div class="mb-4">
                <h1 class="page-title">Konsultasi Saya</h1>
                <p class="page-subtitle">Daftar percakapan dengan psikolog</p>
            </div>
        </div>

        @if($psikolog->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-chat-square-text"></i></div>
            <h2 class="fw-bold mb-3">Belum Ada Konsultasi</h2>
            <p class="text-muted mb-4">Saat ini Anda belum memiliki percakapan dengan psikolog.<br>Mohon tunggu, Psikolog akan segera menghubungi Anda.</p>
            <div class="waiting-badge"><i class="bi bi-clock me-2"></i> Menunggu psikolog</div>
        </div>
        @else
        <div class="chat-cards-container" id="cards-container">
            @foreach($psikolog as $p)
            @php
            $avatarUrl = '';
            if($p->avatar && file_exists(public_path('storage/' . $p->avatar))) {
            $avatarUrl = asset('storage/' . $p->avatar);
            } elseif($p->foto && file_exists(public_path('uploads/' . $p->foto))) {
            $avatarUrl = asset('uploads/' . $p->foto);
            } else {
            $avatarUrl = 'https://ui-avatars.com/api/?name='.urlencode($p->name).'&background=d1fae5&color=047857';
            }
            @endphp

            <div class="chat-card"
                id="card-{{ $p->user_id }}"
                data-psikolog-name="{{ $p->name }}"
                data-avatar-url="{{ $avatarUrl }}"
                data-chat-url="{{ route('korban.chat.show', $p->user_id) }}">

                <div class="profile-header">
                    <div class="avatar-container">
                        <div class="avatar">
                            <img src="{{ $avatarUrl }}" alt="{{ $p->name }}">
                        </div>

                        {{-- STATUS DOT --}}
                        <div id="status-dot-{{ $p->user_id }}"
                            class="status-dot {{ $p->active_status == 1 ? 'online' : '' }}"
                            title="{{ $p->active_status == 1 ? 'Online' : 'Offline' }}">
                        </div>
                    </div>

                    <div class="profile-info">
                        <h3 class="psikolog-name">{{ $p->name }}</h3>
                        <div class="psikolog-title">Psikolog Klinis</div>
                    </div>
                </div>

                <div class="last-message">
                    <div class="d-flex justify-content-between">
                        <span class="last-message-label">Pesan terakhir:</span>
                        <small class="text-muted" id="time-{{ $p->user_id }}"></small>
                    </div>

                    <p class="last-message-text" id="msg-text-{{ $p->user_id }}">
                        @php
                        $lastMessage = \App\Models\Chat::where(function($q) use ($p) {
                        $q->where('sender_id', auth()->id())->where('receiver_id', $p->user_id);
                        })->orWhere(function($q) use ($p) {
                        $q->where('sender_id', $p->user_id)->where('receiver_id', auth()->id());
                        })->latest('created_at')->first();
                        @endphp

                        @if($lastMessage)
                        {{ $lastMessage->sender_id == auth()->id() ? 'Anda: ' : '' }}{{ $lastMessage->message }}
                        @else
                        <em>Belum ada percakapan</em>
                        @endif
                    </p>
                </div>

                <a href="{{ route('korban.chat.show', $p->user_id) }}" class="action-button">
                    <i class="bi bi-chat-left-text"></i> Buka Chat
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentUserId = "{{ Auth::id() }}";

            const audioContext = new(window.AudioContext || window.webkitAudioContext)();
            let notificationSound = true;
            const soundToggle = document.getElementById('soundToggle');

            document.body.addEventListener('click', function() {
                if (audioContext.state === 'suspended') audioContext.resume();
            }, {
                once: true
            });

            function playNotificationSound() {
                if (!notificationSound) return;
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

            function showToast(senderName, message, avatarUrl, chatUrl) {
                const toast = document.createElement('div');
                toast.className = 'toast-notification';

                const imgHtml = avatarUrl ?
                    `<img src="${avatarUrl}" class="toast-avatar" alt="Avatar">` :
                    `<div class="bg-success rounded-circle p-2 text-white"><i class="bi bi-chat-dots"></i></div>`;

                toast.innerHTML = `
                    <div class="d-flex align-items-center gap-3">
                        ${imgHtml}
                        <div style="flex: 1; min-width: 0;">
                            <strong class="d-block text-dark text-truncate">${senderName}</strong>
                            <small class="text-muted text-truncate d-block">${message}</small>
                        </div>
                    </div>
                `;

                toast.onclick = function() {
                    window.location.href = chatUrl;
                };

                toastContainer.appendChild(toast);
                setTimeout(() => toast.remove(), 4000);
            }

            if (soundToggle) {
                soundToggle.addEventListener('click', () => {
                    notificationSound = !notificationSound;
                    if (audioContext.state === 'suspended') audioContext.resume();

                    const icon = soundToggle.querySelector('i');
                    if (notificationSound) {
                        icon.className = 'bi bi-bell-fill text-success';
                        playNotificationSound();
                    } else {
                        icon.className = 'bi bi-bell-slash-fill text-muted';
                    }
                });
            }

            function updateStatusUI(userId, isOnline) {
                const dot = document.getElementById(`status-dot-${userId}`);
                if (dot) {
                    if (isOnline) {
                        dot.classList.add('online');
                        dot.title = "Online";
                    } else {
                        dot.classList.remove('online');
                        dot.title = "Offline";
                    }
                }
            }

            function updateLastMessageUI(userId, message, isMe) {
                const card = document.getElementById(`card-${userId}`);
                const textEl = document.getElementById(`msg-text-${userId}`);
                const timeEl = document.getElementById(`time-${userId}`);

                if (card && textEl) {
                    textEl.innerText = (isMe ? 'Anda: ' : '') + message;

                    const now = new Date();
                    const timeString = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    if (timeEl) timeEl.innerText = timeString;

                    const container = document.getElementById('cards-container');
                    container.prepend(card);

                    if (!isMe) {
                        playNotificationSound();

                        const senderName = card.dataset.psikologName || "Psikolog";
                        const avatarUrl = card.dataset.avatarUrl || "";
                        const chatUrl = card.dataset.chatUrl || "#";

                        showToast(senderName, message, avatarUrl, chatUrl);

                        card.classList.add('new-msg');
                        setTimeout(() => card.classList.remove('new-msg'), 3000);
                    }
                }
            }

            if (typeof Echo !== "undefined") {
                window.Echo.join('presence-chat')
                    .listen('.user.status', (e) => {
                        if (e && e.userId) updateStatusUI(e.userId, e.status == 1);
                    })
                    .here((users) => {
                        users.forEach(user => {
                            const uid = user.user_id || user.id;
                            updateStatusUI(uid, true);
                        });
                    });

                window.Echo.private(`chat.user.${currentUserId}`)
                    .listen('.message.sent', (e) => {
                        updateLastMessageUI(e.chat.sender_id, e.chat.message, false);
                    });
            }
        });
    </script>
</body>

</html>