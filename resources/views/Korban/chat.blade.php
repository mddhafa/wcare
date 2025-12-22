<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }

        .chat-wrapper {
            max-width: 900px;
            margin: auto;
            height: calc(100vh - 110px);
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .chat-header {
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .chat-header img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            background: #fff;
        }

        /* Sound Toggle Button */
        .sound-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sound-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .sound-toggle i {
            font-size: 18px;
        }

        .chat-box {
            flex-grow: 1;
            overflow-y: auto;
            padding: 16px;
            background-color: #e5ddd5;
            background-image: url('https://i.imgur.com/8fK4h7R.png');
        }

        .chat-bubble {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 14px;
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
            transition: all 0.3s ease;
        }

        .chat-me {
            background: #dcf8c6;
            border-bottom-right-radius: 4px;
        }

        .chat-other {
            background: #ffffff;
            border-bottom-left-radius: 4px;
        }

        /* New message animation */
        .new-message {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chat-input {
            padding: 12px;
            background: #f8f9fa;
            border-top: 1px solid #ddd;
        }

        .chat-input .form-control {
            border-radius: 999px;
            padding-left: 44px;
        }

        .attach-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #6c757d;
            cursor: pointer;
        }

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
            min-width: 300px;
            max-width: 400px;
            margin-bottom: 12px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            animation: slideInRight 0.3s ease-out;
            background: white;
            overflow: hidden;
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

        /* Unread indicator badge */
        .unread-indicator {
            position: absolute;
            top: 10px;
            right: 60px;
            background: #dc3545;
            color: white;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 10px;
            font-weight: 600;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        @media (max-width: 576px) {
            .chat-wrapper {
                height: calc(100vh - 80px);
                border-radius: 0;
            }

            .toast-container {
                left: 20px;
                right: 20px;
            }

            .toast-notification {
                min-width: auto;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @include('components.navbar')

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="container-fluid mt-3">
        <div class="chat-wrapper">

            <!-- Header -->
            <div class="chat-header">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($psikolog->name) }}&background=ffffff&color=198754">
                <div>
                    <div class="fw-semibold">{{ $psikolog->name }}</div>
                    <small class="opacity-75">Psikolog UMY</small>
                </div>

                <!-- Unread Indicator -->
                <span class="unread-indicator" id="unreadIndicator" style="display: none;">
                    Pesan Baru
                </span>

                <!-- Sound Toggle Button -->
                <button class="sound-toggle" id="soundToggle" title="Toggle Notifikasi Suara">
                    <i class="bi bi-bell-fill"></i>
                </button>
            </div>

            <!-- Chat Box -->
            <div class="chat-box" id="chatBox">
                @foreach($messages as $msg)
                <div class="d-flex mb-2 {{ $msg->sender_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}" data-message-id="{{ $msg->id }}">
                    <div class="chat-bubble {{ $msg->sender_id == Auth::id() ? 'chat-me' : 'chat-other' }}">
                        {{ $msg->message }}
                        <div class="text-end text-muted mt-1" style="font-size:11px;">
                            {{ $msg->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Input -->
            <form class="chat-input d-flex gap-2" id="chatForm">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $psikolog->user_id }}">
                <div class="position-relative flex-grow-1">
                    <i class="bi bi-paperclip attach-icon"></i>
                    <input type="text" name="message" class="form-control" placeholder="Tulis pesan..." required>
                </div>
                <button class="btn btn-success rounded-circle" style="width:46px;height:46px">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>

        </div>
    </div>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ===========================
        // STATE & DOM ELEMENTS
        // ===========================
        const chatBox = document.getElementById('chatBox');
        const form = document.getElementById('chatForm');
        const sendBtn = form.querySelector("button");
        const psikologId = "{{ $psikolog->user_id }}";
        const toastContainer = document.getElementById('toastContainer');
        const soundToggle = document.getElementById('soundToggle');
        const unreadIndicator = document.getElementById('unreadIndicator');

        let notificationSound = true;
        let isAtBottom = true;
        let lastMessageIds = new Set();
        let isPageVisible = true;
        let unreadCount = 0;
        let audioContext = null;

        // ===========================
        // AUDIO CONTEXT INITIALIZATION
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
        soundToggle.addEventListener('click', function() {
            notificationSound = !notificationSound;
            const icon = this.querySelector('i');

            if (notificationSound) {
                icon.className = 'bi bi-bell-fill';
                showToast('Notifikasi suara diaktifkan', 'success');
            } else {
                icon.className = 'bi bi-bell-slash-fill';
                showToast('Notifikasi suara dinonaktifkan', 'info');
            }
        });

        // ===========================
        // TOAST NOTIFICATION
        // ===========================
        function showToast(message, type = 'info') {
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
                        <strong class="d-block">{{ $psikolog->name }}</strong>
                        <span class="small">${message}</span>
                    </div>
                    <button class="btn-close btn-sm ms-2" onclick="this.closest('.toast-notification').remove()"></button>
                </div>
            `;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // ===========================
        // BROWSER NOTIFICATION
        // ===========================
        function requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
        }

        function showBrowserNotification(message) {
            if ('Notification' in window && Notification.permission === 'granted') {
                const notification = new Notification('Pesan Baru dari {{ $psikolog->name }}', {
                    body: message,
                    icon: 'https://ui-avatars.com/api/?name={{ urlencode($psikolog->name) }}&background=198754&color=ffffff',
                    badge: 'https://ui-avatars.com/api/?name={{ urlencode($psikolog->name) }}&background=198754&color=ffffff',
                    tag: 'chat-notification',
                    renotify: true,
                });

                notification.onclick = function() {
                    window.focus();
                    notification.close();
                };
            }
        }

        // ===========================
        // PAGE VISIBILITY TRACKING
        // ===========================
        document.addEventListener('visibilitychange', function() {
            isPageVisible = !document.hidden;

            if (isPageVisible) {
                // Reset unread when page becomes visible
                unreadCount = 0;
                updateUnreadIndicator();
                document.title = 'Chat - {{ $psikolog->name }}';
            }
        });

        // ===========================
        // UNREAD INDICATOR
        // ===========================
        function updateUnreadIndicator() {
            if (unreadCount > 0 && !isPageVisible) {
                unreadIndicator.textContent = `${unreadCount} Pesan Baru`;
                unreadIndicator.style.display = 'block';
                document.title = `(${unreadCount}) Pesan Baru - Chat`;
            } else {
                unreadIndicator.style.display = 'none';
                document.title = 'Chat - {{ $psikolog->name }}';
            }
        }

        // ===========================
        // SCROLL DETECTION
        // ===========================
        chatBox.addEventListener('scroll', function() {
            const threshold = 50;
            isAtBottom = chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight < threshold;

            // If user scrolls to bottom, mark as read
            if (isAtBottom && !isPageVisible) {
                unreadCount = 0;
                updateUnreadIndicator();
            }
        });

        // ===========================
        // SCROLL TO BOTTOM
        // ===========================
        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // Initial scroll
        scrollToBottom();

        // ===========================
        // INITIALIZE MESSAGE IDS
        // ===========================
        function initializeMessageIds() {
            const existingMessages = chatBox.querySelectorAll('[data-message-id]');
            existingMessages.forEach(msg => {
                lastMessageIds.add(msg.dataset.messageId);
            });
        }
        initializeMessageIds();

        // ===========================
        // REFRESH CHAT WITH NOTIFICATIONS
        // ===========================
        function refreshChat() {
            fetch("{{ route('chat.refresh', $psikolog->user_id) }}")
                .then(res => res.json())
                .then(data => {
                    const existingMessageIds = Array.from(
                        chatBox.querySelectorAll('[data-message-id]')
                    ).map(el => el.dataset.messageId);

                    let hasNewMessage = false;
                    let newMessageText = '';

                    data.messages.forEach(msg => {
                        const messageId = msg.id.toString();

                        if (!existingMessageIds.includes(messageId)) {
                            const isMe = msg.sender_id == "{{ Auth::id() }}";

                            const messageDiv = document.createElement('div');
                            messageDiv.className = `d-flex mb-2 ${isMe ? 'justify-content-end' : 'justify-content-start'} new-message`;
                            messageDiv.dataset.messageId = messageId;

                            messageDiv.innerHTML = `
                                <div class="chat-bubble ${isMe ? 'chat-me' : 'chat-other'}">
                                    ${msg.message}
                                    <div class="text-end text-muted mt-1" style="font-size:11px;">
                                        ${new Date(msg.created_at).toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'})}
                                    </div>
                                </div>
                            `;

                            chatBox.appendChild(messageDiv);

                            // Check if it's an incoming message (from psikolog)
                            if (!isMe && !lastMessageIds.has(messageId)) {
                                hasNewMessage = true;
                                newMessageText = msg.message;
                            }

                            lastMessageIds.add(messageId);
                        }
                    });

                    // Show notifications for new incoming messages
                    if (hasNewMessage) {
                        playNotificationSound();
                        showToast(newMessageText, 'warning');
                        showBrowserNotification(newMessageText);

                        // Increment unread count if page is not visible
                        if (!isPageVisible) {
                            unreadCount++;
                            updateUnreadIndicator();
                        }
                    }

                    // Auto scroll if at bottom
                    if (isAtBottom) {
                        scrollToBottom();
                    }
                });
        }

        // Poll every 3 seconds
        setInterval(refreshChat, 3000);

        // ===========================
        // SEND MESSAGE
        // ===========================
        form.addEventListener("submit", e => {
            e.preventDefault();
            const input = form.querySelector("input[name='message']");
            if (!input.value.trim()) return;

            fetch("{{ route('chat.send') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    receiver_id: "{{ $psikolog->user_id }}",
                    message: input.value
                })
            }).then(() => {
                input.value = "";
                refreshChat();
            });
        });

        // ===========================
        // CHECK PSIKOLOG STARTED
        // ===========================
        async function checkPsikologStarted() {
            try {
                const res = await fetch(`/api/check-psikolog-started/${psikologId}`);
                const data = await res.json();
                sendBtn.disabled = !data.started;
            } catch (err) {
                console.error(err);
                sendBtn.disabled = true;
            }
        }

        // Initial check
        checkPsikologStarted();

        // Check every 5 seconds
        setInterval(checkPsikologStarted, 5000);

        // ===========================
        // INITIALIZE
        // ===========================
        requestNotificationPermission();
        console.log('✅ Chat notifications initialized');
    </script>

</body>

</html>

       

</body>

</html> 
   
