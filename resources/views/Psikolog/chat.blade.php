<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Konsultasi - Psikolog</title>

    {{-- Load Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #059669;
            --primary-light: #d1fae5;
            --primary-hover: #047857;
            --bg-body: #f1f5f9;
            --bg-sidebar: #ffffff;
            --chat-bg: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --navbar-height: 70px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
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

        .btn-back {
            width: 42px;
            height: 42px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
        }

        .btn-back:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateX(-3px);
            box-shadow: 0 4px 10px rgba(5, 150, 105, 0.2);
        }

        .chat-wrapper {
            height: calc(100vh - var(--navbar-height) - 90px);
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            display: flex;
            margin-bottom: 20px;
        }

        .sidebar-col {
            background-color: var(--bg-sidebar);
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
        }

        .search-box {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .search-input {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 16px 10px 40px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .search-input:focus {
            background-color: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .search-icon {
            position: absolute;
            left: 32px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .chat-list-container {
            flex: 1;
            overflow-y: auto;
        }

        .chat-user-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f8fafc;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .chat-user-item:hover {
            background-color: #f8fafc;
        }

        .chat-user-item.active {
            background-color: #f0fdf4;
            border-right: 4px solid var(--primary);
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            min-width: 48px;
            min-height: 48px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
            border: 2px solid #e2e8f0;
            flex-shrink: 0;
        }

        .avatar-placeholder {
            width: 48px;
            height: 48px;
            min-width: 48px;
            min-height: 48px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border: 2px solid white;
            border-radius: 50%;
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #cbd5e1;
        }

        .status-dot.online {
            background-color: #22c55e;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        }

        .unread-badge {
            background-color: #ef4444;
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(239, 68, 68, 0.3);
        }

        .chat-col {
            display: flex;
            flex-direction: column;
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .chat-header {
            padding: 16px 24px;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 10;
        }

        .chat-avatar-header {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            overflow: hidden;
            flex-shrink: 0;
        }

        .chat-avatar-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            scroll-behavior: smooth;
        }

        #emptyState {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--text-muted);
        }

        #emptyState i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .message-bubble {
            max-width: 70%;
            padding: 12px 18px;
            border-radius: 16px;
            position: relative;
            font-size: 0.95rem;
            line-height: 1.5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
            margin-bottom: 4px;
        }

        .chat-me {
            background: var(--primary);
            color: white;
            border-radius: 16px 16px 4px 16px;
            margin-left: auto;
        }

        .bg-white {
            background: white !important;
            color: var(--text-dark);
            border: 1px solid #e2e8f0;
            border-radius: 16px 16px 16px 4px;
        }

        .read-icon {
            font-size: 1rem;
            margin-left: 4px;
            transition: color 0.3s;
        }

        .read-icon.unread {
            color: rgba(255, 255, 255, 0.6);
        }


        .read-icon.read {
            color: #00bfff !important;
            text-shadow: 0 0 5px rgba(0, 191, 255, 0.5);
        }

        .sidebar-icon {
            font-size: 1rem;
            margin-right: 4px;
            transition: color 0.3s;
        }

        .sidebar-icon.unread {
            color: #9ca3af;
        }

        .sidebar-icon.read {
            color: #00bfff !important;
        }


        .chat-footer {
            padding: 16px 24px;
            background: white;
            border-top: 1px solid #e2e8f0;
        }

        .input-group-custom {
            background: #f1f5f9;
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

        #messageInput {
            border: none;
            background: transparent;
            box-shadow: none;
            padding: 10px 16px;
            font-size: 0.95rem;
        }

        #messageInput:focus {
            outline: none;
        }

        #sendBtn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }

        #sendBtn:hover:not(:disabled) {
            background: var(--primary-hover);
            transform: scale(1.05);
        }

        #sendBtn:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
        }

        /* TOAST */
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
    </style>
</head>

<body>

    <div class="navbar-fixed-wrapper">
        @include('components.navbar')
    </div>

    <div id="toastContainer"></div>

    <main class="container-fluid px-lg-5">
        <div class="d-flex align-items-center justify-content-between mb-3 mt-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('psikolog.dashboard-psikolog') }}" class="btn-back" title="Kembali ke Dashboard">
                    <i class="bi bi-arrow-left fs-5"></i>
                </a>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Ruang Konsultasi</h4>
                    <p class="text-muted small mb-0">Kelola percakapan dengan pasien Anda.</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="notification-sound-btn" id="soundToggle" title="Toggle Suara Notifikasi">
                    <i class="bi bi-bell-fill text-success fs-5"></i>
                </div>
                <span class="badge bg-white text-dark border shadow-sm px-3 py-2 rounded-pill">
                    <i class="bi bi-person-lines-fill me-2 text-success"></i>
                    {{ ($users ?? collect())->count() }} Pasien
                </span>
            </div>
        </div>

        <div class="chat-wrapper">
            <div class="col-lg-4 col-md-5 sidebar-col">
                <div class="search-box position-relative">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="search-input w-100" id="searchPatient" placeholder="Cari nama pasien...">
                </div>

                <div class="chat-list-container" id="patientList">
                    @php $psikologId = auth()->user()->user_id; @endphp
                    @forelse($users as $user)
                    @php
                    $avatarUrl = null;
                    if($user->avatar && file_exists(public_path('storage/' . $user->avatar))) {
                    $avatarUrl = asset('storage/' . $user->avatar);
                    } elseif($user->foto && file_exists(public_path('uploads/' . $user->foto))) {
                    $avatarUrl = asset('uploads/' . $user->foto);
                    }
                    @endphp

                    <div class="chat-user-item"
                        data-user-id="{{ $user->user_id }}"
                        data-user-name="{{ $user->name }}"
                        data-user-status="{{ $user->active_status }}"
                        data-avatar-url="{{ $avatarUrl ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=d1fae5&color=047857' }}">

                        <div class="d-flex align-items-center">
                            <div class="position-relative me-3">
                                @if($avatarUrl)
                                <img src="{{ $avatarUrl }}" class="user-avatar" alt="{{ $user->name }}">
                                @else
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                @endif
                                <span class="status-dot {{ $user->active_status == 1 ? 'online' : '' }}"
                                    id="status-dot-{{ $user->user_id }}"></span>
                            </div>

                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 fw-semibold text-truncate text-dark" style="max-width: 140px;">{{ $user->name }}</h6>
                                    <small class="text-muted last-message-time" style="font-size: 0.75rem;">
                                        {{ $user->last_message ? $user->last_message->created_at->setTimezone('Asia/Jakarta')->format('H:i') : '' }}
                                    </small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="small text-muted mb-0 text-truncate last-message-preview {{ $user->unread_count > 0 ? 'fw-bold text-dark' : '' }}" style="max-width: 180px;">
                                        @if($user->last_message)
                                        @if($user->last_message->sender_id == $psikologId)
                                        {{-- ICON CHECK SIDEBAR --}}
                                        <i id="sidebar-check-{{ $user->user_id }}"
                                            class="bi bi-check-all me-1 sidebar-icon {{ $user->last_message->is_read ? 'read' : 'unread' }}"></i>
                                        @endif
                                        {{ $user->last_message->message }}
                                        @else
                                        <em>Belum ada pesan</em>
                                        @endif
                                    </p>
                                    <span class="unread-badge unread-count" id="badge-{{ $user->user_id }}"
                                        style="{{ $user->unread_count > 0 ? '' : 'display: none;' }}">
                                        {{ $user->unread_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-4 text-muted opacity-25"></i>
                        <p class="text-muted mt-3 small">Belum ada pasien</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-8 col-md-7 chat-col position-relative">
                <div class="chat-header" id="chatHeader" style="display: none;">
                    <div class="d-flex align-items-center">
                        <div class="chat-avatar-header me-3 fs-5" id="chatAvatar">?</div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark" id="chatUsername">Pilih Pasien</h6>
                            <small id="chatUserStatus" class="text-muted d-flex align-items-center gap-1">
                                <i class="bi bi-circle-fill" style="font-size: 6px;"></i> Offline
                            </small>
                        </div>
                    </div>
                    <button class="btn btn-light btn-sm rounded-circle border">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                </div>

                <div class="messages-container" id="messages">
                    <div id="emptyState">
                        <i class="bi bi-chat-square-text text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                        <h5 class="text-muted fw-normal">Pilih pasien untuk memulai percakapan</h5>
                        <p class="small text-muted">Pesan Anda terenkripsi dan aman.</p>
                    </div>
                </div>

                <div class="chat-footer bg-white">
                    <form id="messageForm" class="input-group-custom">
                        <input type="text" class="form-control" id="messageInput" placeholder="Ketik pesan..." disabled autocomplete="off">
                        <button class="btn" id="sendBtn" type="submit" disabled>
                            <i class="bi bi-send-fill fs-5"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.body.dataset.psikologId = "{{ auth()->user()->user_id }}";
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SCRIPT CHAT (Sudah diperbaiki ID di sidebar) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatBox = document.getElementById("messages");
            const form = document.getElementById("messageForm");
            const sendBtn = document.getElementById("sendBtn");
            const messageInput = document.getElementById("messageInput");
            const toastContainer = document.getElementById("toastContainer");
            const soundToggle = document.getElementById("soundToggle");
            const patientList = document.getElementById("patientList");
            const searchInput = document.getElementById("searchPatient");
            const chatHeader = document.getElementById("chatHeader");
            const chatUsername = document.getElementById("chatUsername");
            const chatAvatar = document.getElementById("chatAvatar");
            const chatUserStatus = document.getElementById("chatUserStatus");
            const emptyState = document.getElementById("emptyState");
            const psikologId = document.body.dataset.psikologId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            let activeUserId = null;
            let notificationSound = true;
            const audioContext = new(window.AudioContext || window.webkitAudioContext)();

            document.body.addEventListener('click', () => {
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

            function showToast(title, message, avatarUrl = null) {
                const toast = document.createElement('div');
                toast.className = 'toast-notification';
                const imgHtml = avatarUrl ?
                    `<img src="${avatarUrl}" class="toast-avatar" alt="Avatar">` :
                    `<div class="bg-success rounded-circle p-2 text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px"><i class="bi bi-chat-dots-fill"></i></div>`;
                toast.innerHTML = `<div class="d-flex align-items-center gap-3">${imgHtml}<div style="flex: 1; min-width: 0;"><strong class="d-block text-dark text-truncate" style="font-size:0.9rem">${title}</strong><small class="text-muted text-truncate d-block">${message}</small></div></div>`;
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

            if (soundToggle) {
                soundToggle.addEventListener('click', () => {
                    notificationSound = !notificationSound;
                    if (audioContext.state === 'suspended') audioContext.resume();
                    const icon = soundToggle.querySelector('i');
                    icon.className = notificationSound ? 'bi bi-bell-fill text-success fs-5' : 'bi bi-bell-slash-fill text-muted fs-5';
                    if (notificationSound) playNotificationSound();
                });
            }

            function scrollToBottom() {
                if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
            }

            function appendMessageToDOM(msg, type) {
                if (!chatBox) return;
                if (emptyState) emptyState.style.display = "none";
                const isMe = type === "outgoing";
                const time = new Date(msg.created_at || new Date()).toLocaleTimeString("id-ID", {
                    hour: "2-digit",
                    minute: "2-digit"
                });
                let readIcon = "";
                if (isMe) {
                    const statusClass = (msg.is_read == 1 || msg.is_read === true) ? "read" : "unread";
                    const msgId = msg.id || Date.now();
                    readIcon = `<i class="bi bi-check-all read-icon ${statusClass}" id="msg-check-${msgId}"></i>`;
                }
                const html = `<div class="d-flex mb-3 ${isMe ? "justify-content-end" : "justify-content-start"}"><div class="message-bubble rounded-3 px-3 py-2 shadow-sm ${isMe ? "chat-me text-white" : "bg-white border text-dark"}"><div class="message-text">${msg.message}</div><div class="d-flex justify-content-end align-items-center mt-1 gap-1"><small class="${isMe ? "text-white-50" : "text-muted"}" style="font-size: 0.65rem;">${time}</small>${readIcon}</div></div></div>`;
                chatBox.insertAdjacentHTML("beforeend", html);
                scrollToBottom();
            }

            function updateSidebarPreview(userId, message, isOutgoing) {
                const item = document.querySelector(`.chat-user-item[data-user-id="${userId}"]`);
                if (item) {
                    const preview = item.querySelector(".last-message-preview");
                    const timeEl = item.querySelector(".last-message-time");
                    const badge = item.querySelector(".unread-count");
                    if (preview) {
                        const icon = isOutgoing ? `<i id="sidebar-check-${userId}" class="bi bi-check-all me-1 sidebar-icon unread"></i> ` : '';
                        preview.innerHTML = icon + message;
                        if (!isOutgoing && userId != activeUserId) {
                            preview.classList.add("fw-bold", "text-dark");
                            preview.classList.remove("text-muted");
                        } else {
                            preview.classList.remove("fw-bold", "text-dark");
                            preview.classList.add("text-muted");
                        }
                    }
                    if (timeEl) {
                        const now = new Date();
                        timeEl.innerText = now.getHours() + ":" + String(now.getMinutes()).padStart(2, "0");
                    }
                    if (!isOutgoing && userId != activeUserId && badge) {
                        let count = parseInt(badge.innerText || 0) + 1;
                        badge.innerText = count;
                        badge.style.display = "inline-block";
                    }
                    if (patientList) patientList.prepend(item);
                }
            }

            function markMessagesAsRead(senderId) {
                fetch("/psikolog/chat/mark-read", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({
                        sender_id: senderId
                    })
                }).catch(console.error);
            }

            if (patientList) {
                patientList.addEventListener("click", function(e) {
                    const item = e.target.closest(".chat-user-item");
                    if (!item) return;
                    document.querySelectorAll(".chat-user-item").forEach((i) => i.classList.remove("active"));
                    item.classList.add("active");
                    activeUserId = item.dataset.userId;
                    const userName = item.dataset.userName;
                    const isOnline = item.dataset.userStatus == "1";
                    const avatarUrl = item.dataset.avatarUrl;
                    const badge = item.querySelector(".unread-count");
                    if (badge) {
                        badge.innerText = "";
                        badge.style.display = "none";
                    }
                    const preview = item.querySelector(".last-message-preview");
                    if (preview) {
                        preview.classList.remove("fw-bold", "text-dark");
                        preview.classList.add("text-muted");
                    }
                    if (chatHeader) chatHeader.style.display = "flex";
                    if (chatUsername) chatUsername.innerText = userName;
                    if (chatUserStatus) {
                        chatUserStatus.innerHTML = isOnline ? '<i class="bi bi-circle-fill text-success" style="font-size: 6px;"></i> Online' : '<i class="bi bi-circle-fill text-secondary" style="font-size: 6px;"></i> Offline';
                    }
                    if (chatAvatar) {
                        if (avatarUrl) {
                            chatAvatar.innerHTML = `<img src="${avatarUrl}" style="width:100%;height:100%;object-fit:cover;">`;
                            chatAvatar.style.overflow = 'hidden';
                        } else {
                            chatAvatar.innerHTML = userName.charAt(0).toUpperCase();
                        }
                    }
                    if (messageInput) {
                        messageInput.disabled = false;
                        messageInput.focus();
                    }
                    if (sendBtn) sendBtn.disabled = false;
                    loadChatHistory(activeUserId);
                });
            }

            function loadChatHistory(userId) {
                chatBox.innerHTML = '<div class="text-center py-5 text-muted"><div class="spinner-border spinner-border-sm" role="status"></div> Memuat...</div>';
                fetch(`/psikolog/chat/get/${userId}`).then((r) => r.json()).then((data) => {
                    chatBox.innerHTML = "";
                    if (data.messages.length === 0) {
                        if (emptyState) emptyState.style.display = "flex";
                    } else {
                        if (emptyState) emptyState.style.display = "none";
                        data.messages.forEach((msg) => {
                            const type = msg.sender_id == psikologId ? "outgoing" : "incoming";
                            appendMessageToDOM(msg, type);
                        });
                    }
                    markMessagesAsRead(userId);
                });
            }

            if (form) {
                form.addEventListener("submit", function(e) {
                    e.preventDefault();
                    const text = messageInput.value.trim();
                    if (!text || !activeUserId) return;
                    const tempId = Date.now();
                    const tempMsg = {
                        id: tempId,
                        message: text,
                        created_at: new Date(),
                        sender_id: psikologId,
                        is_read: 0
                    };
                    appendMessageToDOM(tempMsg, "outgoing");
                    updateSidebarPreview(activeUserId, text, true);
                    messageInput.value = "";
                    fetch("/psikolog/chat/send", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({
                            receiver_id: activeUserId,
                            message: text
                        })
                    }).then((r) => r.json()).then((data) => {
                        const icon = document.getElementById(`msg-check-${tempId}`);
                        if (icon) icon.id = `msg-check-${data.id}`;
                    });
                });
            }

            if (searchInput) {
                searchInput.addEventListener("input", function() {
                    const term = this.value.toLowerCase();
                    document.querySelectorAll(".chat-user-item").forEach((item) => {
                        const name = item.dataset.userName.toLowerCase();
                        item.style.display = name.includes(term) ? "block" : "none";
                    });
                });
            }

            if (typeof Echo !== "undefined") {
                window.Echo.join('presence-chat')
                    .listen('.user.status', (e) => {
                        const item = document.querySelector(`.chat-user-item[data-user-id="${e.userId}"]`);
                        if (item) {
                            item.dataset.userStatus = e.status;
                            const dot = document.getElementById(`status-dot-${e.userId}`);
                            if (dot) e.status == 1 ? dot.classList.add("online") : dot.classList.remove("online");
                            if (activeUserId == e.userId && chatUserStatus) {
                                chatUserStatus.innerHTML = e.status == 1 ? '<i class="bi bi-circle-fill text-success" style="font-size: 6px;"></i> Online' : '<i class="bi bi-circle-fill text-secondary" style="font-size: 6px;"></i> Offline';
                            }
                        }
                    })
                    .here((users) => {
                        users.forEach((u) => {
                            const dot = document.getElementById(`status-dot-${u.id}`);
                            if (dot) dot.classList.add("online");
                            const item = document.querySelector(`.chat-user-item[data-user-id="${u.id}"]`);
                            if (item) item.dataset.userStatus = "1";
                        });
                    });

                window.Echo.private(`chat.user.${psikologId}`)
                    .listen(".message.sent", (e) => {
                        const senderId = e.chat.sender_id;
                        if (activeUserId && senderId == activeUserId) {
                            appendMessageToDOM(e.chat, "incoming");
                            markMessagesAsRead(senderId);
                        } else {
                            playNotificationSound();
                            const item = document.querySelector(`.chat-user-item[data-user-id="${senderId}"]`);
                            const name = item ? item.dataset.userName : "Pasien";
                            const avatar = item ? item.dataset.avatarUrl : null;
                            showToast(name, e.chat.message, avatar);
                        }
                        updateSidebarPreview(senderId, e.chat.message, false);
                    })
                    .listen(".message.read", (e) => {
                        if (activeUserId == e.sender_id) {
                            document.querySelectorAll(".read-icon.unread").forEach((icon) => {
                                icon.classList.remove("unread");
                                icon.classList.add("read");
                            });
                        }

                        const sidebarIcon = document.getElementById(`sidebar-check-${e.sender_id}`);
                        if (sidebarIcon) {
                            sidebarIcon.classList.remove("unread");
                            sidebarIcon.classList.add("read");
                        }
                    });
            }
        });
    </script>
</body>

</html>