<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat dengan {{ $psikolog->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #059669;
            --primary-light: #d1fae5;
            --primary-dark: #047857;
            --chat-bg: #f3f4f6;
            --bubble-me: #059669;
            --bubble-other: #ffffff;
            --text-me: #ffffff;
            --text-other: #1f2937;
            --navbar-height: 70px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--chat-bg);
            height: 100vh;
            overflow: hidden;
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

        .chat-container {
            max-width: 1000px;
            margin: 20px auto;
            height: calc(100vh - var(--navbar-height) - 40px);
            background: white;
            border-radius: 24px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        .chat-header {
            padding: 16px 24px;
            background: white;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 10;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-icon {
            color: #6b7280;
            transition: color 0.2s;
            background: transparent;
            border: none;
            padding: 5px;
        }

        .btn-icon:hover {
            color: var(--primary);
        }

        .avatar-wrapper {
            position: relative;
            width: 48px;
            height: 48px;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-light);
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            background: var(--primary-light);
            color: var(--primary-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .status-dot-header {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
            background-color: #9ca3af;
            transition: all 0.3s ease;
        }

        .status-dot-header.online {
            background-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
            animation: pulse-green 2s infinite;
        }

        .user-details h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
        }

        .user-status-text {
            font-size: 0.75rem;
            color: #6b7280;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .user-status-text.online {
            color: #059669;
            font-weight: 500;
        }

        .chat-box {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 20px 20px;
            scroll-behavior: smooth;
        }

        .message-row {
            display: flex;
            margin-bottom: 16px;
            animation: fadeIn 0.3s ease;
        }

        .message-row.me {
            justify-content: flex-end;
        }

        .chat-bubble {
            max-width: 70%;
            padding: 12px 16px;
            position: relative;
            font-size: 0.95rem;
            line-height: 1.5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .chat-bubble.other {
            background: var(--bubble-other);
            color: var(--text-other);
            border-radius: 16px 16px 16px 4px;
            border: 1px solid #e5e7eb;
        }

        .chat-bubble.me {
            background: var(--bubble-me);
            color: var(--text-me);
            border-radius: 16px 16px 4px 16px;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
        }

        .meta-info {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
            margin-top: 4px;
            font-size: 0.7rem;
            opacity: 0.9;
        }

        .read-icon {
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .read-icon.unread {
            color: rgba(230, 230, 230, 0.5);
        }

        .read-icon.read {
            color: #00e5ff !important;
            filter: drop-shadow(0 0 2px rgba(0, 229, 255, 0.5));
        }

        .chat-footer {
            padding: 16px 24px;
            background: white;
            border-top: 1px solid #f0f0f0;
        }

        .input-group-custom {
            background: #f3f4f6;
            border-radius: 24px;
            padding: 6px;
            display: flex;
            align-items: center;
            border: 1px solid transparent;
            transition: all 0.3s;
        }

        .input-group-custom:focus-within {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.1);
        }

        .chat-input-field {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px 16px;
            outline: none;
            font-size: 0.95rem;
            color: #1f2937;
        }

        .btn-send {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .btn-send:hover:not(:disabled) {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .btn-send:disabled {
            background: #d1d5db;
            cursor: not-allowed;
        }

        .toast-notification {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 9999;
            background: white;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-left: 4px solid var(--primary);
            animation: slideInRight 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            max-width: 350px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

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

        @media (max-width: 768px) {
            .chat-container {
                height: calc(100vh - var(--navbar-height));
                margin: 0;
                border-radius: 0;
            }

            .chat-header {
                padding: 12px 16px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar-fixed-wrapper">
        @include('components.navbar')
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <div class="chat-container">

        <div class="chat-header">
            <div class="user-info">
                <a href="{{ route('korban.chat.index') }}" class="btn-icon text-decoration-none" title="Kembali ke Daftar Chat">
                    <i class="bi bi-arrow-left fs-5"></i>
                </a>

                <div class="avatar-wrapper">
                    @if($psikolog->avatar)
                    <img src="{{ asset('storage/' . $psikolog->avatar) }}" class="avatar-img" alt="{{ $psikolog->name }}">
                    @else
                    <div class="avatar-placeholder">
                        {{ substr($psikolog->name, 0, 1) }}
                    </div>
                    @endif

                    <div id="status-dot-header" class="status-dot-header {{ $psikolog->active_status == 1 ? 'online' : '' }}"></div>
                </div>

                <div class="user-details">
                    <h5>{{ $psikolog->name }}</h5>
                    @if($psikolog->active_status == 1)
                    <p class="user-status-text online" id="status-text">
                        <i class="bi bi-circle-fill" style="font-size: 6px;"></i> Online
                    </p>
                    @else
                    <p class="user-status-text" id="status-text">Offline</p>
                    @endif
                </div>
            </div>

            <div class="header-actions">
                <button class="btn-icon border-0 bg-transparent" id="soundToggle" title="Suara Notifikasi">
                    <i class="bi bi-bell-fill"></i>
                </button>
            </div>
        </div>

        <div class="chat-box" id="chatBox">
            @foreach($messages as $msg)
            <div class="message-row {{ $msg->sender_id == Auth::id() ? 'me' : 'other' }}">
                <div class="chat-bubble {{ $msg->sender_id == Auth::id() ? 'me' : 'other' }}">
                    <div class="message-text">
                        {{ $msg.message }}
                    </div>
                    <div class="meta-info">
                        <span class="time">{{ $msg->created_at->format('H:i') }}</span>
                        @if($msg->sender_id == Auth::id())
                        <i class="bi bi-check-all read-icon {{ $msg->is_read ? 'read' : 'unread' }}" id="msg-check-{{ $msg->id }}"></i>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="chat-footer">
            <form id="chatForm" class="input-group-custom">
                @csrf
                <input type="text" name="message" id="messageInput"
                    class="chat-input-field"
                    placeholder="{{ $psikolog->active_status == 1 ? 'Ketik pesan...' : 'Menunggu Psikolog online...' }}"
                    {{ $psikolog->active_status == 1 ? '' : 'disabled' }}
                    autocomplete="off">

                <button type="submit" class="btn-send" id="sendBtn" {{ $psikolog->active_status == 1 ? '' : 'disabled' }}>
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.getElementById('chatBox');
            const form = document.getElementById('chatForm');
            const sendBtn = document.getElementById('sendBtn');
            const messageInput = document.getElementById('messageInput');
            const toastContainer = document.getElementById('toastContainer');
            const soundToggle = document.getElementById('soundToggle');
            const statusDot = document.getElementById('status-dot-header');
            const statusText = document.getElementById('status-text');

            const myUserId = "{{ Auth::id() }}";
            const psikologId = "{{ $psikolog->user_id }}";
            const psikologName = "{{ $psikolog->name }}";
            const chatSendUrl = "{{ route('korban.chat.send') }}";
            const markReadUrl = "{{ route('korban.chat.markRead') }}";

            let notificationSound = true;
            let isPageVisible = !document.hidden;

            function scrollToBottom() {
                if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
            }
            scrollToBottom();

            function updatePartnerStatus(isOnline) {
                if (isOnline) {
                    statusDot.classList.add('online');
                    statusText.innerHTML = '<i class="bi bi-circle-fill" style="font-size: 6px;"></i> Online';
                    statusText.classList.add('online');
                    enableInput();
                } else {
                    statusDot.classList.remove('online');
                    statusText.innerHTML = 'Offline';
                    statusText.classList.remove('online');
                }
            }

            function enableInput() {
                messageInput.disabled = false;
                sendBtn.disabled = false;
                messageInput.placeholder = "Ketik pesan...";
            }

            function markMessagesAsRead() {
                fetch(markReadUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        sender_id: psikologId
                    })
                }).catch(console.error);
            }

            function appendMessage(msg, type) {
                const isMe = type === 'outgoing';
                const time = new Date(msg.created_at || new Date()).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                let readIcon = '';
                if (isMe) {
                    const statusClass = (msg.is_read == 1 || msg.is_read === true) ? 'read' : 'unread';
                    const msgId = msg.id || Date.now();
                    readIcon = `<i class="bi bi-check-all read-icon ${statusClass}" id="msg-check-${msgId}"></i>`;
                }

                const html = `
                    <div class="message-row ${isMe ? 'me' : 'other'}">
                        <div class="chat-bubble ${isMe ? 'me' : 'other'}">
                            <div class="message-text">${msg.message}</div>
                            <div class="meta-info">
                                <span class="time">${time}</span>
                                ${readIcon}
                            </div>
                        </div>
                    </div>`;

                chatBox.insertAdjacentHTML('beforeend', html);
                scrollToBottom();
            }

            const audioContext = new(window.AudioContext || window.webkitAudioContext)();

            document.body.addEventListener('click', function() {
                if (audioContext.state === 'suspended') {
                    audioContext.resume();
                }
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
                o.type = "sine";

                g.gain.setValueAtTime(0.1, audioContext.currentTime);
                g.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 0.5);

                o.start();
                o.stop(audioContext.currentTime + 0.5);
            }

            function showToast(message) {
                const toast = document.createElement('div');
                toast.className = 'toast-notification';
                toast.innerHTML = `<div class="d-flex align-items-center gap-3">
                                        <div class="bg-success rounded-circle p-2 text-white"><i class="bi bi-chat-dots"></i></div>
                                        <div>
                                            <strong class="d-block text-dark">${psikologName}</strong>
                                            <small class="text-muted text-truncate d-block" style="max-width: 200px;">${message}</small>
                                        </div>
                                   </div>`;
                toastContainer.appendChild(toast);
                setTimeout(() => toast.remove(), 4000);
            }

            soundToggle.addEventListener('click', () => {
                notificationSound = !notificationSound;
                if (audioContext.state === 'suspended') audioContext.resume();

                soundToggle.querySelector('i').className = notificationSound ? 'bi bi-bell-fill' : 'bi bi-bell-slash-fill';
            });

            document.addEventListener('visibilitychange', () => {
                isPageVisible = !document.hidden;
                if (isPageVisible) {
                    document.title = `Chat dengan ${psikologName}`;
                    markMessagesAsRead();
                }
            });

            if (window.Echo) {
                window.Echo.private('chat.user.' + myUserId)
                    .listen('.message.sent', (e) => {
                        if (e.chat.sender_id == psikologId) {
                            appendMessage(e.chat, 'incoming');
                            playNotificationSound();
                            if (isPageVisible) {
                                markMessagesAsRead();
                            } else {
                                document.title = `(1) Pesan Baru - ${psikologName}`;
                                showToast(e.chat.message);
                            }
                        }
                    })
                    .listen('.message.read', (e) => {
                        if (e.sender_id == psikologId) {
                            document.querySelectorAll('.read-icon.unread').forEach(icon => {
                                icon.classList.remove('unread');
                                icon.classList.add('read');
                            });
                        }
                    });

                window.Echo.join('presence-chat')
                    .listen('.user.status', (e) => {
                        if (e.userId == psikologId) {
                            updatePartnerStatus(e.status == 1);
                        }
                    });
            }

            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const text = messageInput.value.trim();
                if (!text) return;

                const tempMsg = {
                    message: text,
                    created_at: new Date(),
                    sender_id: myUserId,
                    is_read: 0
                };
                appendMessage(tempMsg, 'outgoing');
                messageInput.value = "";

                fetch(chatSendUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            receiver_id: psikologId,
                            message: text
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        const icon = document.getElementById(`msg-check-${tempMsg.id || ''}`);
                        if (icon) icon.id = `msg-check-${data.id}`;
                    });
            });
        });
    </script>
</body>

</html>
