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
        }

        .chat-header img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            background: #fff;
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
        }

        .chat-me {
            background: #dcf8c6;
            border-bottom-right-radius: 4px;
        }

        .chat-other {
            background: #ffffff;
            border-bottom-left-radius: 4px;
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

        @media (max-width: 576px) {
            .chat-wrapper {
                height: calc(100vh - 80px);
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    @include('components.navbar')

    <div class="container-fluid mt-3">
        <div class="chat-wrapper">

            <!-- Header -->
            <div class="chat-header">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($psikolog->name) }}&background=ffffff&color=198754">
                <div>
                    <div class="fw-semibold">{{ $psikolog->name }}</div>
                    <small class="opacity-75">Psikolog UMY</small>
                </div>
            </div>

            <!-- Chat Box -->
            <div class="chat-box" id="chatBox">
                @foreach($messages as $msg)
                <div class="d-flex mb-2 {{ $msg->sender_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
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
        const chatBox = document.getElementById('chatBox');
        const form = document.getElementById('chatForm');
        const sendBtn = form.querySelector("button");
        const psikologId = "{{ $psikolog->user_id }}";

        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
        scrollToBottom();

        function refreshChat() {
            fetch("{{ route('chat.refresh', $psikolog->user_id) }}")
                .then(res => res.json())
                .then(data => {
                    chatBox.innerHTML = "";
                    data.messages.forEach(msg => {
                        const isMe = msg.sender_id == "{{ Auth::id() }}";
                        chatBox.innerHTML += `
                        <div class="d-flex mb-2 ${isMe ? 'justify-content-end' : 'justify-content-start'}">
                            <div class="chat-bubble ${isMe ? 'chat-me' : 'chat-other'}">
                                ${msg.message}
                                <div class="text-end text-muted mt-1" style="font-size:11px;">
                                    ${new Date(msg.created_at).toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'})}
                                </div>
                            </div>
                        </div>`;
                    });
                    scrollToBottom();
                });
        }

        setInterval(refreshChat, 3000);

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

        // ==============================
        // Tombol kirim disable sampai psikolog mulai chat
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

        // Cek pertama kali saat halaman load
        checkPsikologStarted();

        // Cek berkala tiap 5 detik
        setInterval(checkPsikologStarted, 5000);
    </script>

</body>

</html>
