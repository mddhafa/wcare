<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Wcare ChatBot</title>

  <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
  <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
</head>

<body>
  <div class="chat-container">

    <!-- ================= SIDEBAR ================= -->
    <div class="w3-sidebar w3-bar-block w3-card w3-animate-left"
      id="mySidebar" style="display:none;width:250px">

      <div class="sidebar-header">
        <img src="{{ asset('images/Umy-logo.gif') }}">
        <div>
          <div class="sidebar-title">Menu</div>
          <div class="sidebar-subtitle">Riwayat Chat</div>
        </div>
      </div>

      <button id="closeNav" onclick="w3_close()"
        style="position:absolute;top:20px;right:15px;border:none;background:rgba(255,255,255,.1)">
        <img src="images/sidebar (3).png" alt="Close">
      </button>

      <div class="sidebar-actions">
        <button class="sidebar-btn link-btn" onclick="startNewChat()">+ Obrolan Baru</button>
      </div>

      <div class="history-wrap" id="chat-history-list"></div>



      <a href="/dashboard" class="sidebar-btn link-btn">📊 Dashboard</a>
      <a href="/profile" class="sidebar-btn link-btn">👤 Profile</a>
    </div>

    <!-- ================= MAIN ================= -->
    <div class="main-chat" id="main-chat">

      <nav class="navbar">
        <button id="openNav" onclick="w3_open()">
          <img src="images/sidebar.png" alt="Menu">
        </button>
        <span class="navbar-title">Wcare ChatBot</span>
      </nav>

      <!-- CHAT -->
      <div id="chat-box"></div>

      <!-- QUICK REPLIES -->
      <div id="quick-replies" style="display:none;padding:16px">
        <div style="font-weight:600;margin-bottom:10px">Pilihan cepat</div>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          <button class="qr-btn" onclick="useQuick('aku cape banget hari ini aku mau curhat')">
            aku cape banget hari ini aku mau curhat
          </button>
          <button class="qr-btn" onclick="useQuick('apakah ada nomor layanan konseling untuk kejiwaan khusus mahasiswa umy')">
            layanan konseling mahasiswa umy
          </button>
          <button class="qr-btn" onclick="useQuick('saya butuh motivasi')">
            saya butuh motivasi
          </button>
        </div>
      </div>

      <!-- INPUT -->
      <div class="input-area">
        <div class="message-input-wrapper">
          <textarea id="message" placeholder="Ketik pesan Anda di sini..." rows="1"></textarea>
          <button class="send-btn" onclick="sendMessage()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m22 2-7 20-4-9-9-4 20-7Z" />
            </svg>
          </button>
        </div>
      </div>


    </div>
  </div>

  <script>
    /* =================== GLOBAL =================== */
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const chatBox = document.getElementById('chat-box');
    const historyList = document.getElementById('chat-history-list');
    const quickReplies = document.getElementById('quick-replies');
    const messageInput = document.getElementById('message');

    let activeSessionId = null;

    /* =================== HELPERS =================== */
    function escapeHTML(str) {
      return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
    }

    function scrollToBottom() {
      chatBox.scrollTop = chatBox.scrollHeight;
    }

    function showQuick() {
      quickReplies.style.display = 'block';
    }

    function hideQuick() {
      quickReplies.style.display = 'none';
    }

    function greeting() {
      return `<div class="msg-bot"><span>
    Halo! Selamat datang di Wcare ChatBot. Saya siap mendengarkan.
  </span></div>`;
    }

    /* =================== SIDEBAR =================== */
    async function loadSessions() {
      const res = await fetch('/chat/sessions');
      const data = await res.json();
      if (!data.ok) return;

      if (!data.sessions.length) {
        historyList.innerHTML = `<div style="padding:10px;color:#ccc">Belum ada chat</div>`;
        return;
      }

      historyList.innerHTML = data.sessions.map(s => `
    <div class="history-item ${s.id===activeSessionId?'active':''}"
         onclick="openSession(${s.id})">
      <div>${escapeHTML(s.title || 'Obrolan')}</div>
      <small>${new Date(s.updated_at).toLocaleString('id-ID')}</small>
    </div>
  `).join('');
    }

    /* =================== SESSION =================== */
    async function startNewChat() {
      const res = await fetch('/chat/session', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrf
        }
      });
      const data = await res.json();
      if (!data.ok) return alert('Gagal buat chat');

      activeSessionId = data.session_id;
      chatBox.innerHTML = greeting();
      showQuick();
      loadSessions();
      return activeSessionId;
    }

    async function openSession(id) {
      activeSessionId = id;
      loadSessions();

      const res = await fetch(`/chat/messages/${id}`);
      const data = await res.json();
      if (!data.ok) return;

      if (!data.messages.length) {
        chatBox.innerHTML = greeting();
        showQuick();
        return;
      }

      hideQuick();
      chatBox.innerHTML = data.messages.map(m =>
        m.role === 'user' ?
        `<div class="msg-user"><span>${escapeHTML(m.content)}</span></div>` :
        `<div class="msg-bot"><span>${escapeHTML(m.content)}</span></div>`
      ).join('');
      scrollToBottom();
    }

    /* =================== SEND =================== */
    async function sendMessage() {
      const msg = messageInput.value.trim();
      if (!msg) return;

      if (!activeSessionId) {
        const id = await startNewChat();
        if (!id) return;
      }

      hideQuick();
      chatBox.innerHTML += `<div class="msg-user"><span>${escapeHTML(msg)}</span></div>`;
      messageInput.value = '';

      const typingId = 't' + Date.now();
      chatBox.innerHTML += `<div class="msg-bot" id="${typingId}"><span>Typing...</span></div>`;
      scrollToBottom();

      const res = await fetch('/chat/generate', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({
          session_id: activeSessionId,
          message: msg
        })
      });

      const data = await res.json();
      document.getElementById(typingId)?.remove();

      if (!res.ok || !data.ok) {
        chatBox.innerHTML += `<div class="msg-bot"><span>Error</span></div>`;
        return;
      }

      const safeBot = escapeHTML(data.response ?? "").replace(/\n/g, "<br>");
      chatBox.innerHTML += `<div class="msg-bot"><span>${safeBot}</span></div>`;
      scrollToBottom();
      loadSessions();
    }

    function useQuick(text) {
      messageInput.value = text;
      sendMessage();
    }

    /* =================== UI =================== */
    function w3_open() {
      document.getElementById("main-chat").style.marginLeft = "250px";
      document.getElementById("mySidebar").style.display = "block";
    }

    function w3_close() {
      document.getElementById("main-chat").style.marginLeft = "0";
      document.getElementById("mySidebar").style.display = "none";
    }

    /* =================== INIT =================== */
    window.addEventListener('load', async () => {
      await loadSessions();
      const res = await fetch('/chat/sessions');
      const data = await res.json();

      if (data.ok && data.sessions.length) {
        openSession(data.sessions[0].id);
      } else {
        chatBox.innerHTML = greeting();
        showQuick();
      }
    });

    window.sendMessage = sendMessage;
    window.startNewChat = startNewChat;
    window.openSession = openSession;
    window.useQuick = useQuick;
    window.w3_open = w3_open;
    window.w3_close = w3_close;
  </script>
</body>

</html>