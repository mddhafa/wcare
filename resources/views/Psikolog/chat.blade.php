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
            font-family: 'Poppins', sans-serif
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

        /* Toast Notification Styles */
        .toast-notification {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 400px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            animation: slideInRight 0.3s ease;
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

        .toast-notification.hiding {
            animation: slideOutRight 0.3s ease;
        }

        .notification-sound-btn {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .notification-sound-btn:hover {
            transform: scale(1.1);
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
            <div class="d-flex align-items-center gap-3">
                <div class="notification-sound-btn" id="soundToggle" title="Aktifkan/Nonaktifkan Suara Notifikasi">
                    <i class="bi bi-bell-fill text-success" style="font-size: 1.2rem;"></i>
                </div>
                <span class="badge bg-success">
                    <i class="bi bi-person-fill me-1"></i>{{ ($users ?? collect())->count() }} Pasien
                </span>
            </div>
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

    <!-- Toast Container -->
    <div id="toastContainer"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chat JS - Load external file -->
    <script>
        // Pass Laravel data to JavaScript
        document.body.dataset.psikologId = "{{ auth()->user()->user_id }}";
    </script>

    <!-- Add CSRF Token to meta tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Load external chat.js file -->
    <script src="{{ asset('js/chat.js') }}"></script>

</body>

</html>