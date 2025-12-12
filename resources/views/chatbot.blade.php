<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Wcare Mendengar with Chatbot</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
  <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
</head>

<body>
  <div class="chat-container">
    <!-- SIDEBAR -->
    <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none; width:250px;" id="mySidebar">
      <div class="sidebar-header">
        <img src="images/Umy-logo.gif" alt="Logo">
        <div>
          <div class="sidebar-title">Menu</div>
          <div class="sidebar-subtitle">Riwayat Chat</div>
        </div>
      </div>

      <button id="closeNav" onclick="w3_close()"
              style="position:absolute; top:20px; right:15px; border:none; background:rgba(255, 255, 255, 0.1);">
        <img src="images/sidebar (3).png" alt="Close">
      </button>

      <div class="sidebar-actions">
        <button class="btn-newchat" onclick="startNewChat()">+ Obrolan Baru</button>
      </div>

      <div class="history-wrap" id="chat-history-list"></div>

      <hr style="border-color: rgba(255,255,255,0.15); margin: 10px 0;">

      <a href="/dashboard" class="w3-bar-item w3-button">📊 Dashboard</a>
      <a href="/profile" class="w3-bar-item w3-button">👤 Profile</a>
    </div>

    <!-- MAIN -->
    <div class="main-chat" id="main-chat">
      <nav class="navbar">
        <button id="openNav" onclick="w3_open()">
          <img src="images/sidebar.png" alt="Menu">
        </button>
        <span class="navbar-title">
          <div class="status-indicator"></div>
          Wcare ChatBot
        </span>
      </nav>

        
      <div id="chat-box"></div>
        <div id="quick-replies" style="display:none;">
            <div style="color:#1b5e20; font-weight:600; margin-bottom:10px;">
                Pilihan cepat
            </div>

            <div style="display:flex; flex-wrap:wrap; gap:10px;">
                <button class="qr-btn" onclick="useQuick('aku cape banget hari ini aku mau curhat')">
                aku cape banget hari ini aku mau curhat
                </button>

                <button class="qr-btn" onclick="useQuick('apakah ada nomor layanan konseling untuk kejiwaan khusus mahasiswa umy')">
                apakah ada nomor layanan konseling untuk kejiwaan khusus mahasiswa umy
                </button>

                <button class="qr-btn" onclick="useQuick('saya butuh motivasi')">
                saya butuh motivasi
                </button>
            </div>
        </div>
      <div class="input-area">
        <div class="message-input-wrapper">
          <textarea id="message" placeholder="Ketik pesan Anda di sini..." rows="1"></textarea>
          <button class="send-btn" onclick="sendMessage()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m22 2-7 20-4-9-9-4 20-7Z"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // =========================
    // USER CONTEXT (ubah sesuai auth kamu)
    // =========================
    let currentUser = "{{ auth()->id() }}"; // contoh
    let messageInput = document.getElementById('message');
    let chatBox = document.getElementById('chat-box');

    // =========================
    // STORAGE KEYS (per user)
    // =========================
    const USER_KEY = `wcare_user_${currentUser}`;
    const SESSIONS_KEY = `${USER_KEY}_sessions`;
    const ACTIVE_SESSION_KEY = `${USER_KEY}_active_session`;
    const lastUser = localStorage.getItem("wcare_last_user");

    if (lastUser !== String(currentUser)) {
    // ganti user -> jangan tampilkan data user sebelumnya
    localStorage.setItem("wcare_last_user", String(currentUser));
    // (opsional) kalau kamu pernah simpan key general lama, bersihkan:
    localStorage.removeItem("chatHistory");
    localStorage.removeItem("chatUser");
    }

    function startNewChat() { 
        const sessions = getSessions(); 
        const id = "sess_" + Date.now(); 
        sessions.push({ id, title: "Obrolan Baru", html: defaultGreetingHTML(), createdAt: Date.now(), updatedAt: Date.now() }); 
        saveSessions(sessions); 
        setActiveSessionId(id); 
        chatBox.innerHTML = defaultGreetingHTML(); 
        scrollToBottom(); 
        renderHistoryList(); 
        toggleQuickReplies();
    }

    function isNewChatUI() {
    // tampilkan quick replies kalau chat hanya berisi greeting saja
    const html = chatBox.innerHTML.trim();
    return html === "" || html.includes("Halo! Selamat datang di Wcare ChatBot");
    }

    function toggleQuickReplies() {
    const qr = document.getElementById("quick-replies");
    if (!qr) return;
    qr.style.display = isNewChatUI() ? "block" : "none";
    }

    function useQuick(text) {
    messageInput.value = text;
    autoResize(messageInput);
    sendMessage(); // langsung kirim
    }

    window.useQuick = useQuick;


    // =========================
    // HELPERS
    // =========================
    function escapeHTML(str) {
      return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }

    function autoResize(el) {
      el.style.height = '34px';
      if (el.scrollHeight > 34 && el.scrollHeight <= 150) el.style.height = el.scrollHeight + 'px';
      else if (el.scrollHeight > 150) el.style.height = '150px';
      scrollToBottom();
    }

    function scrollToBottom() {
      chatBox.scrollTop = chatBox.scrollHeight;
    }

    function defaultGreetingHTML() {
      return `
        <div class="msg-bot">
          <span>Halo! Selamat datang di Wcare ChatBot. Saya di sini untuk mendengarkan Anda. Ada yang bisa saya bantu hari ini?</span>
        </div>
      `;
    }

    function formatTime(ts) {
      const d = new Date(ts);
      const date = d.toLocaleDateString('id-ID', { day:'2-digit', month:'short' });
      const time = d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
      return `${date} ${time}`;
    }

    // =========================
    // SESSIONS CRUD
    // =========================
    function getSessions() {
      return JSON.parse(localStorage.getItem(SESSIONS_KEY) || "[]");
    }

    function saveSessions(sessions) {
      localStorage.setItem(SESSIONS_KEY, JSON.stringify(sessions));
    }

    function getActiveSessionId() {
      return localStorage.getItem(ACTIVE_SESSION_KEY);
    }

    function setActiveSessionId(id) {
      localStorage.setItem(ACTIVE_SESSION_KEY, id);
    }

    function ensureSession() {
      let sessions = getSessions();
      let activeId = getActiveSessionId();

      if (!activeId || !sessions.find(s => s.id === activeId)) {
        const id = "sess_" + Date.now();
        sessions.push({
          id,
          title: "Obrolan Baru",
          html: defaultGreetingHTML(),
          createdAt: Date.now(),
          updatedAt: Date.now()
        });
        saveSessions(sessions);
        setActiveSessionId(id);
      }
    }

    function renderHistoryList() {
      const list = document.getElementById("chat-history-list");
      const sessions = getSessions().sort((a,b) => b.updatedAt - a.updatedAt);
      const activeId = getActiveSessionId();

      if (!sessions.length) {
        list.innerHTML = `<div style="color:rgba(255,255,255,0.6); padding:10px; font-size:13px;">
          Belum ada riwayat.
        </div>`;
        return;
      }

      list.innerHTML = sessions.map(s => `
        <div class="history-item ${s.id===activeId?'active':''}" onclick="openSession('${s.id}')">
          <div class="history-title">${escapeHTML(s.title || "Obrolan")}</div>
          <div class="history-time">${formatTime(s.updatedAt)}</div>
        </div>
      `).join("");
    }

    function openSession(id) {
      const sessions = getSessions();
      const session = sessions.find(s => s.id === id);
      if (!session) return;

      setActiveSessionId(id);
      chatBox.innerHTML = session.html || defaultGreetingHTML();
      scrollToBottom();
      renderHistoryList();
    }

    function updateActiveSession(html, titleCandidate) {
      const sessions = getSessions();
      const activeId = getActiveSessionId();
      const idx = sessions.findIndex(s => s.id === activeId);
      if (idx === -1) return;

      sessions[idx].html = html;
      sessions[idx].updatedAt = Date.now();

      if ((sessions[idx].title === "Obrolan Baru" || !sessions[idx].title) && titleCandidate) {
        let t = titleCandidate.trim();
        if (t.length > 28) t = t.slice(0, 28) + "…";
        sessions[idx].title = t;
      }

      saveSessions(sessions);
      renderHistoryList();
    }

    // =========================
    // SIDEBAR OPEN/CLOSE
    // =========================
    function w3_open() {
      document.getElementById("main-chat").style.marginLeft = "250px";
      document.getElementById("mySidebar").style.width = "250px";
      document.getElementById("mySidebar").style.display = "block";
      document.getElementById("openNav").style.display = 'none';
    }

    function w3_close() {
      document.getElementById("main-chat").style.marginLeft = "0";
      document.getElementById("mySidebar").style.display = "none";
      document.getElementById("openNav").style.display = "inline-block";
    }

    // =========================
    // SEND MESSAGE
    // =========================
    function sendMessage() {
      let msg = messageInput.value;
      if (msg.trim() === "") return;

      const safeMsg = escapeHTML(msg);

      // append user bubble
      chatBox.innerHTML += `<div class="msg-user"><span>${safeMsg}</span></div>`;
      updateActiveSession(chatBox.innerHTML, msg);

      messageInput.value = "";
      autoResize(messageInput);

      // typing bubble
      let typingId = "typing-" + Date.now();
      chatBox.innerHTML += `
        <div class="msg-bot" id="${typingId}">
          <div class="typing">Typing...</div>
        </div>
      `;
      updateActiveSession(chatBox.innerHTML);
      scrollToBottom();

      setTimeout(() => {
        fetch('/chat/generate', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ message: msg })
        })
        .then(res => {
          if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
          return res.json();
        })
        .then(data => {
          const typingEl = document.getElementById(typingId);
          if (typingEl) typingEl.remove();

          const safeBot = escapeHTML(data.response ?? "");
          chatBox.innerHTML += `<div class="msg-bot"><span>${safeBot}</span></div>`;

          updateActiveSession(chatBox.innerHTML);
          scrollToBottom();
        })
        .catch(err => {
          const typingEl = document.getElementById(typingId);
          if (typingEl) typingEl.remove();

          chatBox.innerHTML += `<div class="msg-bot"><span>Error: ${escapeHTML(err)}</span></div>`;
          updateActiveSession(chatBox.innerHTML);
          scrollToBottom();
        });
      }, 800);
    }

    // enter to send
    messageInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });

    messageInput.addEventListener('input', function() {
      autoResize(this);
    });

    window.addEventListener('load', function() {
      ensureSession();
      openSession(getActiveSessionId());
      renderHistoryList();
      autoResize(messageInput);
      toggleQuickReplies();
    });

    // expose to inline onclick
    window.startNewChat = startNewChat;
    window.openSession = openSession;
    window.w3_open = w3_open;
    window.w3_close = w3_close;
    window.sendMessage = sendMessage;
  </script>
</body>
</html>
