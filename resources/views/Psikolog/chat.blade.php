<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Konsultasi - Psikolog</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 70px;
        }

        .chat-user-item {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .chat-user-item:hover {
            background-color: #f8f9fa !important;
        }

        .chat-user-item.active {
            background-color: #e6f4ea !important;
            border-left: 4px solid #006A4E !important;
        }

        .message-bubble {
            max-width: 75%;
            word-wrap: break-word;
        }

        .message-bubble.new-message {
            animation: fadeIn 0.3s ease;
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

        .messages-container {
            height: calc(80vh - 80px);
            overflow-y: auto;
            scroll-behavior: smooth;
        }

        .messages-container::-webkit-scrollbar {
            width: 6px;
        }

        .messages-container::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }

        .chat-list-container {
            height: 80vh;
            overflow-y: auto;
        }

        .chat-list-container::-webkit-scrollbar {
            width: 6px;
        }

        .chat-list-container::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }

        .unread-badge {
            width: 8px;
            height: 8px;
            background-color: #006A4E;
            border-radius: 50%;
        }
    </style>
</head>

<body class="bg-light">

    @include('components.navbar')

    <main class="container py-4">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-chat-dots-fill text-success me-2"></i>Ruang Konsultasi
                </h3>
                <p class="text-muted mb-0 small">Kelola percakapan dengan pasien Anda</p>
            </div>
            <span class="badge bg-success">
                <i class="bi bi-person-fill me-1"></i>{{ ($users ?? collect())->count() }} Pasien
            </span>
        </div>

        <!-- Chat Container -->
        <div class="row g-0 shadow-sm rounded-3 overflow-hidden bg-white">

            <!-- LIST PASIEN (Left Sidebar) -->
            <div class="col-lg-4 col-md-5 border-end">
                <div class="chat-list-container">
                    <!-- Search Bar -->
                    <div class="p-3 border-bottom bg-light sticky-top">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text"
                                class="form-control border-start-0"
                                id="searchPatient"
                                placeholder="Cari pasien...">
                        </div>
                    </div>

                    <!-- User List -->
                    <div id="patientList">
                        @php $psikologId = auth()->user()->user_id; @endphp

                        @forelse($users as $user)
                        @php
                        $lastMessage = \App\Models\Chat::where(function($q) use ($psikologId, $user) {
                        $q->where('sender_id', $psikologId)->where('receiver_id', $user->user_id);
                        })
                        ->orWhere(function($q) use ($psikologId, $user) {
                        $q->where('sender_id', $user->user_id)->where('receiver_id', $psikologId);
                        })
                        ->latest('id')->first();
                        @endphp

                        <div class="chat-user-item border-bottom p-3"
                            data-user-id="{{ $user->user_id }}"
                            data-user-name="{{ $user->name }}">
                            <div class="d-flex align-items-center">
                                <!-- Avatar -->
                                <div class="position-relative me-3">
                                    @if($user->foto)
                                    <img src="{{ asset('uploads/' . $user->foto) }}"
                                        class="rounded-circle"
                                        width="50"
                                        height="50"
                                        style="object-fit: cover;"
                                        alt="{{ $user->name }}">
                                    @else
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px; font-size: 20px;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    @endif
                                    <span class="position-absolute bottom-0 end-0 unread-badge"></span>
                                </div>

                                <!-- Info -->
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="mb-0 fw-semibold text-truncate">{{ $user->name }}</h6>
                                        @if($lastMessage)
                                        <small class="text-muted">
                                            {{ $lastMessage->created_at->format('H:i') }}
                                        </small>
                                        @endif
                                    </div>
                                    <p class="small text-muted mb-0 text-truncate">
                                        @if($lastMessage)
                                        @if($lastMessage->sender_id == $psikologId)
                                        <i class="bi bi-check-all text-success me-1"></i>
                                        @endif
                                        {{ $lastMessage->message }}
                                        @else
                                        <em>Belum ada pesan</em>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-3">Belum ada pasien</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- MESSAGE BOX (Right Side) -->
            <div class="col-lg-8 col-md-7 d-flex flex-column">

                <!-- Chat Header -->
                <div class="border-bottom p-3 bg-light" id="chatHeader" style="display: none;">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                            style="width: 40px; height: 40px; font-size: 18px;"
                            id="chatAvatar">
                            ?
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold" id="chatUsername">Pilih Pasien</h6>
                            <small class="text-success">
                                <i class="bi bi-circle-fill" style="font-size: 8px;"></i> Online
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="messages-container flex-grow-1 p-4 bg-light"
                    id="messages"
                    style="background-image: url('https://i.imgur.com/8fK4h7R.png'); background-repeat: repeat;">

                    <!-- Empty State -->
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center" id="emptyState">
                        <i class="bi bi-chat-left-text display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Pilih pasien untuk memulai percakapan</h5>
                        <p class="small text-muted">Pesan Anda akan muncul di sini</p>
                    </div>

                </div>

                <!-- Input Area -->
                <div class="border-top p-3 bg-white">
                    <form id="messageForm" class="d-flex gap-2">
                        <input type="text"
                            class="form-control rounded-pill"
                            id="messageInput"
                            placeholder="Ketik pesan..."
                            disabled>
                        <button class="btn rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 45px; height: 45px; background-color: #006A4E; color: white;"
                            id="sendBtn"
                            type="submit"
                            disabled>
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-info-circle me-1"></i>
                        Tekan Enter untuk mengirim pesan
                    </small>
                </div>

            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const chatUsers = document.querySelectorAll('.chat-user-item');
        const messagesDiv = document.getElementById('messages');
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const messageForm = document.getElementById('messageForm');
        const emptyState = document.getElementById('emptyState');
        const chatHeader = document.getElementById('chatHeader');
        const chatUsername = document.getElementById('chatUsername');
        const chatAvatar = document.getElementById('chatAvatar');
        const searchInput = document.getElementById('searchPatient');

        let activeUserId = null;
        let pollInterval = null;
        let lastMessageCount = 0;
        let isAtBottom = true;
        const psikologId = "{{ auth()->user()->user_id }}";

        /** SEARCH PATIENT */
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            chatUsers.forEach(user => {
                const userName = user.dataset.userName.toLowerCase();
                if (userName.includes(searchTerm)) {
                    user.style.display = 'block';
                } else {
                    user.style.display = 'none';
                }
            });
        });

        /** CHECK IF USER AT BOTTOM */
        messagesDiv.addEventListener('scroll', function() {
            const threshold = 50;
            isAtBottom = messagesDiv.scrollHeight - messagesDiv.scrollTop - messagesDiv.clientHeight < threshold;
        });

        /** RENDER SINGLE MESSAGE */
        function renderMessage(msg, isNew = false) {
            const isMe = msg.sender_id == psikologId;

            const messageWrapper = document.createElement('div');
            messageWrapper.className = `d-flex mb-3 ${isMe ? 'justify-content-end' : 'justify-content-start'}`;
            messageWrapper.dataset.messageId = msg.id;

            const messageBubble = document.createElement('div');
            messageBubble.className = `message-bubble rounded-3 px-3 py-2 shadow-sm ${isMe ? 'text-white' : 'bg-white'} ${isNew ? 'new-message' : ''}`;
            messageBubble.style.backgroundColor = isMe ? '#006A4E' : '#ffffff';

            const messageText = document.createElement('p');
            messageText.className = 'mb-1';
            messageText.textContent = msg.message;

            const messageTime = document.createElement('small');
            messageTime.className = isMe ? 'text-white-50' : 'text-muted';
            messageTime.style.fontSize = '11px';
            messageTime.textContent = new Date(msg.created_at).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            messageBubble.appendChild(messageText);
            messageBubble.appendChild(messageTime);
            messageWrapper.appendChild(messageBubble);

            return messageWrapper;
        }

        /** REFRESH CHAT - HANYA UPDATE JIKA ADA PERUBAHAN */
        function refreshChat(data) {
            emptyState.style.display = 'none';

            if (!data.messages || data.messages.length === 0) {
                if (messagesDiv.children.length <= 1) { // Only empty state exists
                    messagesDiv.innerHTML = `
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-chat-left-dots display-4 d-block mb-3"></i>
                            <p>Belum ada pesan. Mulai percakapan!</p>
                        </div>
                    `;
                }
                return;
            }

            // Cek apakah ada pesan baru
            if (data.messages.length === lastMessageCount) {
                return; // Tidak ada perubahan, skip refresh
            }

            // Jika ada pesan baru, tambahkan hanya pesan baru
            const existingMessageIds = Array.from(messagesDiv.querySelectorAll('[data-message-id]'))
                .map(el => el.dataset.messageId);

            data.messages.forEach(msg => {
                if (!existingMessageIds.includes(msg.id.toString())) {
                    const messageElement = renderMessage(msg, true);
                    messagesDiv.appendChild(messageElement);
                }
            });

            lastMessageCount = data.messages.length;

            // Auto scroll hanya jika user sudah di bawah
            if (isAtBottom) {
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }
        }

        /** LOAD INITIAL CHAT */
        function loadChat(userId) {
            fetch(`/psikolog/chat/${userId}`)
                .then(r => r.json())
                .then(data => {
                    // Clear dan render semua pesan
                    messagesDiv.innerHTML = '';
                    emptyState.style.display = 'none';

                    if (!data.messages || data.messages.length === 0) {
                        messagesDiv.innerHTML = `
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-chat-left-dots display-4 d-block mb-3"></i>
                                <p>Belum ada pesan. Mulai percakapan!</p>
                            </div>
                        `;
                        lastMessageCount = 0;
                    } else {
                        data.messages.forEach(msg => {
                            const messageElement = renderMessage(msg, false);
                            messagesDiv.appendChild(messageElement);
                        });
                        lastMessageCount = data.messages.length;
                        messagesDiv.scrollTop = messagesDiv.scrollHeight;
                    }
                })
                .catch(err => console.error('Error loading chat:', err));
        }

        /** KLIK PASIEN */
        chatUsers.forEach(user => {
            user.addEventListener('click', function() {
                chatUsers.forEach(u => u.classList.remove('active'));
                this.classList.add('active');

                activeUserId = this.dataset.userId;
                const userName = this.dataset.userName;

                // Update header
                chatHeader.style.display = 'block';
                chatUsername.textContent = userName;
                chatAvatar.textContent = userName.charAt(0).toUpperCase();

                messageInput.disabled = false;
                sendBtn.disabled = false;
                messageInput.focus();

                // Load initial messages
                loadChat(activeUserId);

                // Start polling dengan interval lebih lama
                if (pollInterval) clearInterval(pollInterval);

                pollInterval = setInterval(() => {
                    if (activeUserId) {
                        fetch(`/psikolog/chat/${activeUserId}`)
                            .then(r => r.json())
                            .then(data => refreshChat(data))
                            .catch(err => console.error('Error polling:', err));
                    }
                }, 3000); // Poll setiap 3 detik (lebih lambat)
            });
        });

        /** KIRIM PESAN */
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const text = messageInput.value.trim();
            if (!text || !activeUserId) return;

            sendBtn.disabled = true;

            fetch('/psikolog/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: activeUserId,
                        message: text
                    })
                })
                .then(r => r.json())
                .then(data => {
                    messageInput.value = "";
                    sendBtn.disabled = false;
                    messageInput.focus();

                    // Reload messages setelah kirim
                    loadChat(activeUserId);
                })
                .catch(err => {
                    console.error('Error sending message:', err);
                    sendBtn.disabled = false;
                    alert('Gagal mengirim pesan. Coba lagi.');
                });
        });

        // Stop polling when leaving page
        window.addEventListener('beforeunload', function() {
            if (pollInterval) clearInterval(pollInterval);
        });
    </script>

</body>

</html>