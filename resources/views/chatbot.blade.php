<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wcare Mendengar with Chatbot Gemini</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #ffff; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            color: #1b5e20;
        }

        .chat-container {
            width: 2000px;
            height: 950px;
            background: #ffffff; 
            border-radius: 0px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            overflow: hidden;
            border: 1px solid #c8e6c9;
        }

        /* MAIN CHAT AREA */
        .main-chat {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: center; /* Teks tetap di tengah */
            background: #14532d;
            padding: 15px 20px;
            color: white;
            font-size: 20px;
            font-weight: 600;
            position: relative;
        }

        .navbar #openNav {
            position: absolute;
            left: 10px;
        }

        #openNav {
            background-color: #14532d; /* warna hijau */
            border: none;               /* hilangkan border default */
            border-radius: 10px;           /* hilangkan rounded */
            width: 40px;                /* lebar tombol */
            height: 40px;               /* tinggi tombol */
            display: flex;              /* center isi tombol */
            justify-content: center;
            align-items: center;
            transition: transform .2s; /* Animation */
            cursor: pointer;
            padding: 0;                 /* hapus padding agar proporsional */
        }

        #openNav:hover {
            /* background-color: #43a047;  warna saat hover */
            transform: scale(1.5)
        }

        #openNav img {
            width: 24px;
            height: 24px;
        }

        #closeNav {
            transition: transform .2s; /* Animation */
        }

        #closeNav:hover {
            transform: scale(1.5)
        }

        /* .navbar-title {
    flex: 1;
    text-align: center;
} */
        .navbar::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: #14532d;
        }

        /* CHAT BOX */
        #chat-box {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
            /* background: #f1f8e9; hijau super muda */
            background: #ffff;
            scrollbar-width: thin;
            scrollbar-color: #66bb6a #c8e6c9;
        }

        #chat-box::-webkit-scrollbar {
            width: 8px;
        }
        #chat-box::-webkit-scrollbar-track {
            background: #c8e6c9;
            border-radius: 10px;
        }
        #chat-box::-webkit-scrollbar-thumb {
            background: #66bb6a;
            border-radius: 10px;
        }
        #chat-box::-webkit-scrollbar-thumb:hover {
            background: #43a047;
        }

        .msg-user, .msg-bot {
            margin: 15px 0;
            display: flex;
            animation: fadein 0.4s ease-out;
        }

        /* USER bubble */
        .msg-user {
            justify-content: flex-end;
        }
        .msg-user span {
            background: #66bb6a;
            color: white;
            padding: 14px 18px;
            border-radius: 18px 18px 4px 18px;
            max-width: 75%;
            word-wrap: break-word;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        /* BOT bubble */
        .msg-bot {
            justify-content: flex-start;
        }
        .msg-bot span {
            background: white;
            color: #1b5e20;
            padding: 14px 18px;
            border-radius: 18px 18px 18px 4px;
            max-width: 75%;
            word-wrap: break-word;
            border: 1px solid #c8e6c9;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* INPUT AREA */
        .input-area {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 20px;
            border-top: 1px solid #c8e6c9;
            background: #ffffff;
        }

        .message-input-wrapper {
            display: flex; /* Mengatur textarea dan button berdampingan */
            align-items: flex-end; /* Penting: agar tombol sejajar dengan bagian bawah textarea */
            width: 100%; /* Memenuhi lebar input-area */
            max-width: 1000px; /* Opsional: Batasi lebar maksimum wrapper */
            background: #f1f8e9; /* Background untuk area input secara keseluruhan */
            border-radius: 25px; /* Border radius untuk wrapper */
            border: 2px solid #c8e6c9; /* Border untuk wrapper */
            padding: 8px 10px; /* Padding di dalam wrapper */
            box-sizing: border-box; /* Pastikan padding tidak menambah ukuran total */
        }

       textarea {
            flex: 1; /* Memastikan textarea mengambil ruang sebanyak mungkin */
            padding: 0; /* Hapus padding default textarea */
            border: none; /* Hapus border default textarea */
            background: none; /* Hapus background default textarea */
            color: #1b5e20;
            font-size: 16px;
            outline: none;
            resize: none; 
            overflow-y: hidden;
            height: auto;
            min-height: 34px; /* Tinggi minimum textarea di dalam wrapper */
            line-height: 20px; /* Atur line-height agar teks tidak terlalu rapat */
            margin-right: 10px; /* Jarak antara textarea dan button */
            align-self: flex-end; /* Agar textarea juga sejajar di bawah jika wrapper membesar */
            max-height: 150px; /* Opsional: Batasi tinggi maksimum textarea agar tidak terlalu besar */
            scrollbar-width: thin; /* Untuk Firefox */
            scrollbar-color: #66bb6a #f1f8e9; /* Untuk Firefox */
        }

        /* Styling scrollbar untuk textarea (Webkit) */
        textarea::-webkit-scrollbar {
            width: 8px;
        }
        textarea::-webkit-scrollbar-track {
            background: #f1f8e9; /* Track sesuai background input wrapper */
            border-radius: 10px;
        }
        textarea::-webkit-scrollbar-thumb {
            background: #66bb6a;
            border-radius: 10px;
        }
        textarea::-webkit-scrollbar-thumb:hover {
            background: #43a047;
        }

        /* Hapus styling input:focus, textarea:focus */
        /* Fokus border dan shadow sekarang ada di .message-input-wrapper */
        .message-input-wrapper:focus-within {
            border-color: #66bb6a;
            box-shadow: 0 0 10px rgba(102, 187, 106, 0.4);
        }

        button {
            
            margin-left: 0;
            padding: 8px; 
            width: 40px; 
            height: 40px; 
            background: #43a047;
            color: white;
            border: none;
            border-radius: 50%; 
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s ease;
            display: flex; 
            justify-content: center;
            align-items: center;
            flex-shrink: 0; 
        }

        button:hover {
            background: #2e7d32;
            transform: none; /* Hapus translateY agar tidak bergerak */
        }
        
        button svg {
            width: 20px; /* Ukuran ikon SVG */
            height: 20px;
            fill: none;
            stroke: currentColor;
            display: block;
        }
        .typing {
            background: #ffffff;
            padding: 15px 20px;
            border: 1px solid #c8e6c9;
            border-radius: 18px 18px 18px 4px;
            color: #2e7d32;
        }
        .typing span {
            animation: blink 1.4s infinite both;
        }

        /* ANIMATIONS */
        @keyframes blink {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 1; }
        }

        @keyframes fadein {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

    </style>
</head>
<body>

<div class="chat-container">
    <!-- <aside class="sidebar">
        <h3>Models</h3>
        <ul>
            <li class="active">Gemini</li>
            <li>ChatGPT</li>
            <li>Claude</li>
            <a href="/dashboard" class="block py-2 px-3 rounded-lg hover:bg-blue-100 text-gray-700 font-medium">back</a>
           
        </ul>
    </aside> -->

    <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none; width:250px;" id="mySidebar">
        <!-- Sidebar Header -->
        <div style="display:flex; align-items:center; padding:10px;">
            <!-- Logo -->
            <img src="images/Umy-logo.gif" alt="UMY Curhat" style="width:40px; height:40px; margin-right:10px;">
        </div>

        <!-- Close Button -->
        <button id="closeNav"onclick="w3_close()" 
                style="position:absolute; top:10px; right:10px; border:none; background:none;">
            <img src="images/sidebar.png" alt="Close" style="width:24px; height:24px;">
        </button>

        <!-- Sidebar Menu -->
        <a href="/dashboard" class="w3-bar-item w3-button">Dashboard</a>
        <a href="#" class="w3-bar-item w3-button">Profile</a>
        <a href="#" class="w3-bar-item w3-button">Settings</a>
    </div>

    <div class="main-chat" id="main-chat">
        <nav class="navbar">
            <button id="openNav" onclick="w3_open()">
                <img src="images/sidebar (3).png" alt="Close" style="width:24px; height:24px;">
            </button>
            <span class="navbar-title">Wcare ChatBot</span>
        </nav>


        <div id="chat-box"></div>

        <div class="input-area">
            <div class="message-input-wrapper"> <textarea id="message" placeholder="Ketik pesan..." rows="1"></textarea> 
                <button onclick="sendMessage()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                            fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m22 2-7 20-4-9-9-4 20-7Z"/>
                        </svg>                
                </button>
            </div>
        </div>
    </div>
</div>

<script>

    // function hapusChatHistory() {
    //     localStorage.removeItem("chatHistory");
    //     document.getElementById("chat-box").innerHTML = "";
    // }

    // ================================
    // RESET CHAT Jika user berbeda
    // ================================
    let currentUser = "{{ auth()->id() }}"; 
    let savedUser = localStorage.getItem("chatUser");
    let messageInput = document.getElementById('message'); // Ambil elemen TEXTAREA di sini!

    if (savedUser !== currentUser) {
        localStorage.removeItem("chatHistory");  // reset riwayat chat
        localStorage.setItem("chatUser", currentUser); 
    }

    // =========================================================================
    // 2. FUNGSI UTAMA (load, save, scroll, resize)
    // =====
    function autoResize(el) {
        // Set tinggi ke minimum awal (misalnya 34px, sama dengan min-height di CSS)
        el.style.height = '34px'; // Sesuaikan dengan min-height CSS Anda
        
        // Jika scrollHeight (tinggi konten) lebih besar dari min-height
        // dan kurang dari max-height yang ditentukan di CSS
        if (el.scrollHeight > 34 && el.scrollHeight <= 150) { // Sesuaikan 150 dengan max-height CSS
            el.style.height = (el.scrollHeight) + 'px'; 
        } else if (el.scrollHeight > 150) {
            // Jika melebihi max-height, set tinggi ke max-height dan biarkan scrollbar internal muncul
            el.style.height = '150px'; // Sesuaikan dengan max-height CSS Anda
        }
        
        // PENTING: Scroll ke bawah chat-box setiap kali input di-resize
        scrollToBottom();
    }

    // ================================
    // Load chat history dari localStorage
    // ================================
    function loadChatHistory() {
        let history = localStorage.getItem("chatHistory");
        if (history) {
            document.getElementById("chat-box").innerHTML = history;
            scrollToBottom();
        }
    }

    loadChatHistory();

    // ================================
    // Save chat history
    // ================================
    function saveChatHistory() {
        let content = document.getElementById("chat-box").innerHTML;
        localStorage.setItem("chatHistory", content);
    }

    // ================================
    // Scroll ke paling bawah
    // ================================
    function scrollToBottom() {
        let box = document.getElementById("chat-box");
        box.scrollTop = box.scrollHeight;
    }

    // ================================
    // KIRIM PESAN
    // ================================
    function sendMessage() {
        let msg = document.getElementById('message').value;
        if (msg.trim() === "") return;

        let chatBox = document.getElementById('chat-box');

        // Tampilkan pesan user
        chatBox.innerHTML += `
            <div class="msg-user"><span>${msg}</span></div>
        `;
        saveChatHistory();

        // Kosongkan input
        // document.getElementById('message').value = "";
        messageInput.value = "";
        autoResize(messageInput); // Sesuaikan tinggi TEXTAREA setelah mengosongkan


        // Tampilkan animasi bot mengetik
        let typingId = "typing-" + Date.now();
        chatBox.innerHTML += `
            <div class="msg-bot" id="${typingId}">
                <div class="typing">
                    <span>Typing</span>
                </div>
            </div>
        `;
        saveChatHistory();

        chatBox.scrollTop = chatBox.scrollHeight;

        // Kirim request ke Flask
        fetch('/chat/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: msg })
        })
        // .then(res => res.json())
        .then(res => {
            // Check if the response is OK and JSON
            if (!res.ok) {
                throw new Error(`HTTP error! Status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            // Hapus typing animation
            document.getElementById(typingId).remove();

            // Tambahkan pesan bot
            chatBox.innerHTML += `
                <div class="msg-bot"><span>${data.response}</span></div>
            `;
            saveChatHistory();

            chatBox.scrollTop = chatBox.scrollHeight;
        })
        .catch(err => {     
            document.getElementById(typingId).remove();

            chatBox.innerHTML += `
                <div class="msg-bot"><span>Error: ${err}</span></div>
            `;
            saveChatHistory();
        });
    }
    
    messageInput.addEventListener('input', function() {
        autoResize(this);
    });

    function w3_open() {
        document.getElementById("main-chat").style.marginLeft = "15%";
        document.getElementById("mySidebar").style.width = "15%";
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("openNav").style.display = 'none';
    }
    function w3_close() {
        document.getElementById("main-chat").style.marginLeft = "0%";
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("openNav").style.display = "inline-block";
    }

    document.getElementById('message').addEventListener('keypress', function(e) {
        // Mendeteksi tombol 'Enter'
        if (e.key === 'Enter') {
            if (!e.shiftKey) {
            e.preventDefault(); // Mencegah baris baru yang tidak diinginkan
            sendMessage();      // Kirim pesan
        }
        } 
    });

    loadChatHistory();
    // Panggil autoResize setelah semua inisialisasi selesai (saat window load)
    window.addEventListener('load', function() {
        autoResize(messageInput);
    });
</script>

</body>
</html>