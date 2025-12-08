<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wcare Mendengar with Chatbot</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            color: #1b5e20;
        }

        .chat-container {
            width: 100%;
            height: 100vh;
            background: #ffffff;
            display: flex;
            overflow: hidden;
        }

        /* SIDEBAR */
        .w3-sidebar {
            background: #14532d;
            color: white;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-header img {
            width: 50px;
            height: 50px;
            margin-right: 15px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .sidebar-title {
            font-size: 19px;
            font-weight: 700;
            color: white;
            letter-spacing: 0.5px;
        }

        .sidebar-subtitle {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 3px;
        }

        .w3-bar-item {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            color: rgba(255, 255, 255, 0.85);
            padding: 16px 20px;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .w3-bar-item:hover {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: #66bb6a;
            color: white;
            padding-left: 24px;
        }

        .w3-bar-item.active {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: #66bb6a;
            font-weight: 600;
        }

        .menu-icon {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(0, 0, 0, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: white;
        }

        .user-status {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
        }

        /* MAIN CHAT AREA */
        .main-chat {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, #f8fffe 0%, #ffffff 100%);
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #14532d;
            padding: 20px;
            color: white;
            font-size: 20px;
            font-weight: 600;
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar #openNav {
            position: absolute;
            left: 20px;
        }

        #openNav {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            width: 45px;
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
            backdrop-filter: blur(10px);
        }

        #openNav:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.05);
        }

        #openNav img, #closeNav img {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
        }

        #closeNav {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        #closeNav:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .navbar-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* CHAT BOX */
        #chat-box {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background: linear-gradient(180deg, #fefefe 0%, #f9fffe 100%);
            scrollbar-width: thin;
            scrollbar-color: #66bb6a #e8f5e9;
        }

        #chat-box::-webkit-scrollbar {
            width: 8px;
        }
        #chat-box::-webkit-scrollbar-track {
            background: #e8f5e9;
            border-radius: 10px;
        }
        #chat-box::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #66bb6a 0%, #43a047 100%);
            border-radius: 10px;
        }
        #chat-box::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #43a047 0%, #2e7d32 100%);
        }

        .msg-user, .msg-bot {
            margin: 20px 0;
            display: flex;
            animation: slideIn 0.4s ease-out;
        }

        /* USER bubble */
        .msg-user {
            justify-content: flex-end;
        }
        .msg-user span {
            background: linear-gradient(135deg, #66bb6a 0%, #43a047 100%);
            color: white;
            padding: 16px 20px;
            border-radius: 20px 20px 4px 20px;
            max-width: 70%;
            word-wrap: break-word;
            box-shadow: 0 4px 15px rgba(102, 187, 106, 0.3);
            position: relative;
        }

        .msg-user span::before {
            content: '';
            position: absolute;
            bottom: 0;
            right: -8px;
            width: 20px;
            height: 20px;
            background: #43a047;
            border-bottom-left-radius: 16px;
        }

        .msg-user span::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: -10px;
            width: 10px;
            height: 20px;
            background: linear-gradient(180deg, #fefefe 0%, #f9fffe 100%);
            border-bottom-left-radius: 10px;
        }

        /* BOT bubble */
        .msg-bot {
            justify-content: flex-start;
        }
        .msg-bot span {
            background: white;
            color: #1b5e20;
            padding: 16px 20px;
            border-radius: 20px 20px 20px 4px;
            max-width: 70%;
            word-wrap: break-word;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .msg-bot span::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: -8px;
            width: 20px;
            height: 20px;
            background: white;
            border-bottom-right-radius: 16px;
            border: 1px solid #e0e0e0;
            border-top: none;
            border-right: none;
        }

        .msg-bot span::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: -10px;
            width: 10px;
            height: 20px;
            background: linear-gradient(180deg, #fefefe 0%, #f9fffe 100%);
            border-bottom-right-radius: 10px;
        }

        /* INPUT AREA */
        .input-area {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            border-top: 1px solid #e8f5e9;
            background: white;
        }

        .message-input-wrapper {
            display: flex;
            align-items: flex-end;
            width: 100%;
            max-width: 900px;
            background: #f1f8e9;
            border-radius: 28px;
            border: 2px solid #c8e6c9;
            padding: 10px 15px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .message-input-wrapper:focus-within {
            border-color: #66bb6a;
            box-shadow: 0 0 0 4px rgba(102, 187, 106, 0.1);
            background: white;
        }

       textarea {
            flex: 1;
            padding: 0;
            border: none;
            background: none;
            color: #1b5e20;
            font-size: 16px;
            outline: none;
            resize: none; 
            overflow-y: hidden;
            height: auto;
            min-height: 34px;
            line-height: 22px;
            margin-right: 10px;
            align-self: flex-end;
            max-height: 150px;
            scrollbar-width: thin;
            scrollbar-color: #66bb6a #f1f8e9;
        }

        textarea::placeholder {
            color: #81c784;
        }

        textarea::-webkit-scrollbar {
            width: 6px;
        }
        textarea::-webkit-scrollbar-track {
            background: transparent;
        }
        textarea::-webkit-scrollbar-thumb {
            background: #66bb6a;
            border-radius: 10px;
        }

        button {
            margin-left: 0;
            padding: 0;
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #43a047 0%, #2e7d32 100%);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(67, 160, 71, 0.4);
        }

        button:hover {
            background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(67, 160, 71, 0.5);
        }

        button:active {
            transform: scale(0.95);
        }
        
        button svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            display: block;
        }

        .typing {
            background: white;
            padding: 16px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 20px 20px 20px 4px;
            color: #66bb6a;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            font-size: 16px;
        }

        /* ANIMATIONS */

        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateY(20px);
            }
            to { 
                opacity: 1; 
                transform: translateY(0);
            }
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .msg-user span, .msg-bot span {
                max-width: 85%;
            }

            .navbar {
                padding: 15px;
            }

            #chat-box {
                padding: 20px 15px;
            }
        }

    </style>
</head>
<body>

<div class="chat-container">
    <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none; width:250px;" id="mySidebar">
        <div class="sidebar-header">
            <img src="images/Umy-logo.gif" alt="Logo">
            <span class="sidebar-title">Menu</span>
        </div>

        <button id="closeNav" onclick="w3_close()" 
                style="position:absolute; top:20px; right:15px; border:none; background:rgba(255, 255, 255, 0.1);">
            <img src="images/sidebar (3).png" alt="Close">
        </button>

        <a href="/dashboard" class="w3-bar-item w3-button">📊 Dashboard</a>
        <a href="/profile" class="w3-bar-item w3-button">👤 Profile</a> 
    </div>

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

        <div id="chat-box">
            <div class="msg-bot">
                <span>Halo! Selamat datang di Wcare ChatBot. Saya di sini untuk mendengarkan Anda. Ada yang bisa saya bantu hari ini?</span>
            </div>
        </div>

        <div class="input-area">
            <div class="message-input-wrapper">
                <textarea id="message" placeholder="Ketik pesan Anda di sini..." rows="1"></textarea> 
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
    let currentUser = "demo_user"; 
    let savedUser = localStorage.getItem("chatUser");
    let messageInput = document.getElementById('message');

    if (savedUser !== currentUser) {
        localStorage.removeItem("chatHistory");
        localStorage.setItem("chatUser", currentUser); 
    }

    function autoResize(el) {
        el.style.height = '34px';
        
        if (el.scrollHeight > 34 && el.scrollHeight <= 150) {
            el.style.height = (el.scrollHeight) + 'px'; 
        } else if (el.scrollHeight > 150) {
            el.style.height = '150px';
        }
        
        scrollToBottom();
    }

    function loadChatHistory() {
        let history = localStorage.getItem("chatHistory");
        if (history) {
            document.getElementById("chat-box").innerHTML = history;
            scrollToBottom();
        }
    }

    loadChatHistory();

    function saveChatHistory() {
        let content = document.getElementById("chat-box").innerHTML;
        localStorage.setItem("chatHistory", content);
    }

    function scrollToBottom() {
        let box = document.getElementById("chat-box");
        box.scrollTop = box.scrollHeight;
    }

    function sendMessage() {
        let msg = messageInput.value;
        if (msg.trim() === "") return;

        let chatBox = document.getElementById('chat-box');

        chatBox.innerHTML += `
            <div class="msg-user"><span>${msg}</span></div>
        `;
        saveChatHistory();

        messageInput.value = "";
        autoResize(messageInput);

        let typingId = "typing-" + Date.now();
        chatBox.innerHTML += `
            <div class="msg-bot" id="${typingId}">
                <div class="typing">
                    Typing...
                </div>
            </div>
        `;
        saveChatHistory();
        scrollToBottom();

        // Simulasi respons bot (ganti dengan fetch ke server Anda)
        setTimeout(() => {
            document.getElementById(typingId).remove();
            
            chatBox.innerHTML += `
                <div class="msg-bot"><span>Terima kasih telah berbagi. Saya mendengarkan Anda dengan penuh perhatian. Bisakah Anda ceritakan lebih lanjut?</span></div>
            `;
            saveChatHistory();
            scrollToBottom();
        }, 1500);
    }
    
    messageInput.addEventListener('input', function() {
        autoResize(this);
    });

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

    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    window.addEventListener('load', function() {
        autoResize(messageInput);
    });
</script>

</body>
</html>