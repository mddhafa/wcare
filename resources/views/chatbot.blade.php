<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Wcare ChatBot</title>

  <link rel="icon" href="{{ asset('images/WeCare.jpeg') }}" type="image/png">
  <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}" />
</head>

<body class="sidebar-closed">
  <div class="chat-container">
    <!-- Overlay for mobile -->
    <div class="overlay" onclick="w3_close()"></div>

    <!-- SIDEBAR -->
    <aside id="mySidebar">
      <button id="closeNav" onclick="w3_close()" aria-label="Tutup menu">✕</button>
      <div class="sidebar-header">
        <img src="{{ asset('images/Umy-logo.gif') }}" alt="Logo">
        <div>
          <div class="sidebar-title">Menu</div>
          <div class="sidebar-subtitle">Riwayat Chat</div>
        </div>
      </div>

      <div class="sidebar-actions">
        <button class="sidebar-btn" onclick="startNewChat()">+ Obrolan Baru</button>
      </div>

      <div class="history-wrap" id="chat-history-list"></div>

      <div class="sidebar-footer">
        <a href="{{ route('dashboard') }}" class="sidebar-link">
          <span class="sidebar-ico">
            <img src="{{ asset('images/menu.png') }}" alt="Dashboard">
          </span>
          <span class="sidebar-txt">Dashboard</span>
        </a>

        <a href="{{ route('korban.profilekorban') }}" class="sidebar-link">
          <span class="sidebar-ico">
            <img src="{{ asset('images/user (1).png') }}" alt="Profile">
          </span>
          <span class="sidebar-txt">Profile</span>
        </a>
      </div>

    </aside>

    <!-- MAIN -->
    <main class="main-chat" id="main-chat">
      <nav class="navbar">
        <button id="navToggle" onclick="toggleSidebar()" aria-label="Toggle menu">
          <!-- icon hamburger -->
          <svg class="icon icon-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round">
            <path d="M4 6h16M4 12h16M4 18h16"/>
          </svg>

          <!-- icon close -->
          <svg class="icon icon-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round">
            <path d="M18 6 6 18M6 6l12 12"/>
          </svg>
        </button>

        <span class="navbar-title">Wcare ChatBot</span>
      </nav>


      <div id="chat-box"></div>

      <div id="quick-replies" style="display:none;">
        <div class="qr-title">Pilihan cepat</div>
        <div class="qr-row">
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

      <div class="input-area">
        <div class="message-input-wrapper">
          <textarea id="message" placeholder="Ketik pesan Anda di sini..." rows="1"></textarea>
          <button class="send-btn" onclick="sendMessage()" aria-label="Kirim">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m22 2-7 20-4-9-9-4 20-7Z" />
            </svg>
          </button>
        </div>
      </div>
    </main>
  </div>

  <script>
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const chatBox = document.getElementById('chat-box');
    const historyList = document.getElementById('chat-history-list');
    const quickReplies = document.getElementById('quick-replies');
    const messageInput = document.getElementById('message');

    let activeSessionId = null;

    function escapeHTML(str) {
      return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
    }

    function renderBotMarkdown(raw) {
      const lines = String(raw ?? "").replace(/\r\n/g, "\n").split("\n");
      let html = "";
      let inUl = false;
      let inOl = false;

      const closeLists = () => {
        if (inUl) { html += "</ul>"; inUl = false; }
        if (inOl) { html += "</ol>"; inOl = false; }
      };

      const inline = (s) => {
        s = s.replace(/`([^`]+)`/g, "<code>$1</code>");
        s = s.replace(/\*\*([^*]+)\*\*/g, "<strong>$1</strong>");
        s = s.replace(/(^|[^*])\*([^*]+)\*(?!\*)/g, "$1<em>$2</em>");
        return s;
      };

      for (let line of lines) {
        const esc = escapeHTML(line);

        const h3 = esc.match(/^###\s+(.*)$/);
        const h2 = esc.match(/^##\s+(.*)$/);
        const h1 = esc.match(/^#\s+(.*)$/);

        if (h1 || h2 || h3) {
          closeLists();
          const text = inline((h1 || h2 || h3)[1]);
          const tag = h1 ? "h2" : h2 ? "h3" : "h4";
          html += `<${tag}>${text}</${tag}>`;
          continue;
        }

        const ol = esc.match(/^\s*\d+\.\s+(.*)$/);
        if (ol) {
          if (!inOl) { closeLists(); html += "<ol>"; inOl = true; }
          html += `<li>${inline(ol[1])}</li>`;
          continue;
        }

        const ul = esc.match(/^\s*[-*]\s+(.*)$/);
        if (ul) {
          if (!inUl) { closeLists(); html += "<ul>"; inUl = true; }
          html += `<li>${inline(ul[1])}</li>`;
          continue;
        }

        if (esc.trim() === "") {
          closeLists();
          html += `<div class="spacer"></div>`;
          continue;
        }

        closeLists();
        html += `<p>${inline(esc)}</p>`;
      }

      closeLists();
      return html;
    }

    function scrollToBottom() {
      chatBox.scrollTop = chatBox.scrollHeight;
    }

    function showQuick() { quickReplies.style.display = 'block'; }
    function hideQuick() { quickReplies.style.display = 'none'; }

    function greeting() {
      return `
        <div class="msg-bot">
          <div class="bubble bot">
            Halo! Selamat datang di Wcare ChatBot. Saya siap mendengarkan.
          </div>
        </div>
      `;
    }

    function toggleSidebar() {
  const isMobile = window.matchMedia("(max-width: 900px)").matches;

  if (document.body.classList.contains("sidebar-closed")) {
    document.body.classList.remove("sidebar-closed");
    if (isMobile) document.body.classList.add("sidebar-open");
  } else {
    document.body.classList.add("sidebar-closed");
    document.body.classList.remove("sidebar-open");
  }
}

    function initSidebarState() {
      if (window.matchMedia("(max-width: 900px)").matches) {
        document.body.classList.add("sidebar-closed");
        document.body.classList.remove("sidebar-open");
      } else {
        document.body.classList.remove("sidebar-closed");
        document.body.classList.remove("sidebar-open");
      }
    }

    function w3_open() {
      if (window.matchMedia("(max-width: 900px)").matches) {
        document.body.classList.remove("sidebar-closed");
        document.body.classList.add("sidebar-open");
      } else {
        document.body.classList.remove("sidebar-closed");
      }
    }

    function w3_close() {
      document.body.classList.add("sidebar-closed");
      document.body.classList.remove("sidebar-open");
    }

    async function loadSessions() {
      const res = await fetch('/chat/sessions');
      const data = await res.json();
      if (!data.ok) return;

      if (!data.sessions.length) {
        historyList.innerHTML = `<div class="history-empty">Belum ada chat</div>`;
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

    async function startNewChat() {
      const res = await fetch('/chat/session', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf }
      });
      const data = await res.json();
      if (!data.ok) return alert('Gagal buat chat');

      activeSessionId = data.session_id;
      chatBox.innerHTML = greeting();
      showQuick();
      loadSessions();
      scrollToBottom();
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
        scrollToBottom();
        return;
      }

      hideQuick();

      chatBox.innerHTML = data.messages.map(m => {
        if (m.role === 'user') {
          return `
            <div class="msg-user">
              <div class="bubble user">${escapeHTML(m.content).replace(/\n/g,"<br>")}</div>
            </div>
          `;
        }
        return `
          <div class="msg-bot">
            <div class="bubble bot">${renderBotMarkdown(m.content)}</div>
          </div>
        `;
      }).join('');

      scrollToBottom();
      if (window.matchMedia("(max-width: 900px)").matches) w3_close();
    }


    async function sendMessage() {
      const msg = messageInput.value.trim();
      if (!msg) return;

      if (!activeSessionId) {
        const id = await startNewChat();
        if (!id) return;
      }

      hideQuick();

      chatBox.innerHTML += `
        <div class="msg-user">
          <div class="bubble user">${escapeHTML(msg).replace(/\n/g,"<br>")}</div>
        </div>
      `;

      messageInput.value = '';
      autoGrow(messageInput);

      const typingId = 't' + Date.now();
      chatBox.innerHTML += `
        <div class="msg-bot" id="${typingId}">
          <div class="bubble bot">Typing...</div>
        </div>
      `;

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
        chatBox.innerHTML += `
          <div class="msg-bot">
            <div class="bubble bot">Maaf, terjadi error. Coba lagi ya.</div>
          </div>
        `;
        scrollToBottom();
        return;
      }

      chatBox.innerHTML += `
        <div class="msg-bot">
          <div class="bubble bot">${renderBotMarkdown(data.response ?? "")}</div>
        </div>
      `;

      scrollToBottom();
      loadSessions();
    }

    function useQuick(text) {
      messageInput.value = text;
      autoGrow(messageInput);
      sendMessage();
    }

    function autoGrow(el){
      el.style.height = "auto";
      el.style.height = Math.min(el.scrollHeight, 140) + "px";
    }

    messageInput.addEventListener("input", () => autoGrow(messageInput));
    messageInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });

    window.addEventListener('load', async () => {
      initSidebarState();
      autoGrow(messageInput);

      await loadSessions();
      const res = await fetch('/chat/sessions');
      const data = await res.json();

      if (data.ok && data.sessions.length) {
        openSession(data.sessions[0].id);
      } else {
        chatBox.innerHTML = greeting();
        showQuick();
        scrollToBottom();
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
