<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    @include('components.navbar')

    <div class="container mt-5 pt-4">

        <!-- Header Chat WhatsApp Style -->
        <div class="bg-success text-white rounded-top-3 p-3 d-flex align-items-center gap-3 mt-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($psikolog->name) }}&background=ffffff&color=157347"
                class="rounded-circle bg-white" style="width: 45px; height: 45px; object-fit: cover;">

            <div>
                <h5 class="mb-0 fw-bold">{{ $psikolog->name }}</h5>
                <small class="opacity-75">Psikolog UMY</small>
            </div>
        </div>

        <!-- Chat Box -->
        <div class="border border-top-0 rounded-bottom-3 p-3 overflow-auto"
            id="chatBox"
            style="height: 480px; background-color: #e5ddd5; background-image: url('https://i.imgur.com/8fK4h7R.png'); background-repeat: repeat;">

            @foreach($messages as $msg)
            <div class="my-2 d-flex {{ $msg->sender_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="shadow-sm rounded-3 px-3 py-2"
                    style="max-width: 70%; background-color: {{ $msg->sender_id == Auth::id() ? '#dcf8c6' : '#ffffff' }};">
                    <p class="mb-0" style="font-size: 15px; line-height: 1.4;">{{ $msg->message }}</p>
                    <small class="text-muted d-block text-end" style="font-size: 11px;">
                        {{ $msg->created_at->format('H:i') }}
                    </small>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Send Message -->
        <form action="{{ route('chat.send') }}" method="POST" class="d-flex align-items-center gap-2 mb-5 mt-3">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $psikolog->user_id }}">

            <div class="position-relative flex-grow-1">
                <span class="position-absolute text-secondary" style="left: 15px; top: 50%; transform: translateY(-50%); font-size: 20px; cursor: pointer;">
                    <i class="bi bi-paperclip"></i>
                </span>

                <input type="text"
                    name="message"
                    class="form-control rounded-pill bg-white border ps-5 pe-4 py-2"
                    placeholder="Tulis pesan..."
                    required>
            </div>

            <button type="submit" class="btn btn-success rounded-circle border-0 d-flex align-items-center justify-content-center"
                style="width: 48px; height: 48px; min-width: 48px;">
                <i class="bi bi-send-fill fs-5"></i>
            </button>
        </form>

    </div>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const chatBox = document.getElementById('chatBox');

        /** 🔽 Auto scroll ke bawah */
        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        scrollToBottom();

        /** 🔄 Refresh Chat (Polling) */
        function refreshChat() {
            fetch("{{ route('chat.refresh', $psikolog->user_id) }}")
                .then(res => res.json())
                .then(data => {
                    if (!data.messages) return;

                    // Kosongkan chat
                    chatBox.innerHTML = "";

                    // Render ulang pesan
                    data.messages.forEach(msg => {

                        const isMe = msg.sender_id == "{{ Auth::id() }}";

                        const wrapper = document.createElement("div");
                        wrapper.className = `my-2 d-flex ${isMe ? 'justify-content-end' : 'justify-content-start'}`;

                        const bubble = `
                        <div class="shadow-sm rounded-3 px-3 py-2"
                             style="max-width: 70%; background-color: ${isMe ? '#dcf8c6' : '#ffffff'};">
                            <p class="mb-0" style="font-size: 15px;">${msg.message}</p>
                            <small class="text-muted d-block text-end" style="font-size: 11px;">
                                ${new Date(msg.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}
                            </small>
                        </div>
                    `;

                        wrapper.innerHTML = bubble;
                        chatBox.appendChild(wrapper);
                    });

                    scrollToBottom();
                })
                .catch(err => console.error("Refresh chat error:", err));
        }

        /** ⏳ Polling tiap 3 detik */
        setInterval(refreshChat, 3000);

        /** ✉️ Kirim pesan AJAX */
        document.querySelector("form").addEventListener("submit", function(e) {
            e.preventDefault();

            const messageField = this.querySelector("input[name='message']");
            const text = messageField.value.trim();
            if (!text) return;

            fetch("{{ route('chat.send') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        receiver_id: "{{ $psikolog->user_id }}",
                        message: text
                    })
                })
                .then(res => res.json())
                .then(data => {
                    messageField.value = "";
                    refreshChat();
                })
                .catch(err => console.error("Send message error:", err));
        });
    </script>


</body>

</html>