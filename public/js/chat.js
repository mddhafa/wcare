// chat.js - Konsultasi Chat Management

// DOM Elements
const chatUsers = document.querySelectorAll(".chat-user-item");
const messagesDiv = document.getElementById("messages");
const messageInput = document.getElementById("messageInput");
const sendBtn = document.getElementById("sendBtn");
const messageForm = document.getElementById("messageForm");
const emptyState = document.getElementById("emptyState");
const chatHeader = document.getElementById("chatHeader");
const chatUsername = document.getElementById("chatUsername");
const chatAvatar = document.getElementById("chatAvatar");
const searchInput = document.getElementById("searchPatient");
const toastContainer = document.getElementById("toastContainer");
const soundToggle = document.getElementById("soundToggle");

// State Variables
let activeUserId = null;
let globalPollInterval = null;
let activeChatPollInterval = null;
let lastMessageCount = 0;
let isAtBottom = true;
let notificationSound = true;
let lastMessageIds = new Set();
let globalLastMessageIds = new Set();

// Get psikolog ID from data attribute
const psikologId =
    document.body.dataset.psikologId ||
    document.querySelector("[data-psikolog-id]")?.dataset.psikologId;
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

// Create notification sound
const audioContext = new (window.AudioContext || window.webkitAudioContext)();

/**
 * Play notification sound
 */
function playNotificationSound() {
    if (!notificationSound) return;

    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();

    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);

    oscillator.frequency.value = 800;
    oscillator.type = "sine";

    gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
    gainNode.gain.exponentialRampToValueAtTime(
        0.01,
        audioContext.currentTime + 0.3
    );

    oscillator.start(audioContext.currentTime);
    oscillator.stop(audioContext.currentTime + 0.3);
}

/**
 * Toggle notification sound on/off
 */
function initSoundToggle() {
    soundToggle.addEventListener("click", function () {
        notificationSound = !notificationSound;
        const icon = this.querySelector("i");

        if (notificationSound) {
            icon.className = "bi bi-bell-fill text-success";
            showToast("Notifikasi suara diaktifkan", null, "success");
        } else {
            icon.className = "bi bi-bell-slash-fill text-muted";
            showToast("Notifikasi suara dinonaktifkan", null, "info");
        }
    });
}

/**
 * Request notification permission
 */
function requestNotificationPermission() {
    if ("Notification" in window && Notification.permission === "default") {
        Notification.requestPermission();
    }
}

/**
 * Show toast notification
 */
function showToast(message, userName = null, type = "info") {
    const toast = document.createElement("div");
    toast.className = "toast-notification";

    const bgColor =
        type === "success"
            ? "#d4edda"
            : type === "info"
            ? "#d1ecf1"
            : "#fff3cd";
    const iconColor =
        type === "success"
            ? "#155724"
            : type === "info"
            ? "#0c5460"
            : "#856404";
    const icon =
        type === "success"
            ? "check-circle-fill"
            : type === "info"
            ? "info-circle-fill"
            : "chat-dots-fill";

    toast.innerHTML = `
        <div class="d-flex align-items-center p-3 border-start border-4" style="border-color: ${iconColor} !important; background-color: ${bgColor};">
            <i class="bi bi-${icon} me-3" style="font-size: 1.5rem; color: ${iconColor};"></i>
            <div class="flex-grow-1">
                ${
                    userName
                        ? `<strong class="d-block">${userName}</strong>`
                        : ""
                }
                <span class="small">${message}</span>
            </div>
            <button class="btn-close btn-sm ms-2" onclick="this.closest('.toast-notification').remove()"></button>
        </div>
    `;

    toastContainer.appendChild(toast);

    setTimeout(() => {
        toast.classList.add("hiding");
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

/**
 * Show browser notification
 */
function showBrowserNotification(userName, message) {
    if ("Notification" in window && Notification.permission === "granted") {
        const notification = new Notification(`Pesan Baru dari ${userName}`, {
            body: message,
            icon: "/path-to-icon.png",
            badge: "/path-to-badge.png",
            tag: "chat-notification",
            renotify: true,
        });

        notification.onclick = function () {
            window.focus();
            notification.close();
        };
    }
}

/**
 * Initialize search patient functionality
 */
function initSearchPatient() {
    searchInput.addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase();
        chatUsers.forEach((user) => {
            const userName = user.dataset.userName.toLowerCase();
            if (userName.includes(searchTerm)) {
                user.style.display = "block";
            } else {
                user.style.display = "none";
            }
        });
    });
}

/**
 * Check if user is at bottom of chat
 */
function initScrollDetection() {
    messagesDiv.addEventListener("scroll", function () {
        const threshold = 50;
        isAtBottom =
            messagesDiv.scrollHeight -
                messagesDiv.scrollTop -
                messagesDiv.clientHeight <
            threshold;
    });
}

/**
 * Render single message
 */
function renderMessage(msg, isNew = false) {
    const isMe = msg.sender_id == psikologId;

    const messageWrapper = document.createElement("div");
    messageWrapper.className = `d-flex mb-3 ${
        isMe ? "justify-content-end" : "justify-content-start"
    }`;
    messageWrapper.dataset.messageId = msg.id;

    const messageBubble = document.createElement("div");
    messageBubble.className = `message-bubble rounded-3 px-3 py-2 shadow-sm ${
        isMe ? "text-white" : "bg-white"
    } ${isNew ? "new-message" : ""}`;
    messageBubble.style.backgroundColor = isMe ? "#006A4E" : "#ffffff";

    const messageText = document.createElement("p");
    messageText.className = "mb-1";
    messageText.textContent = msg.message;

    const messageTime = document.createElement("small");
    messageTime.className = isMe ? "text-white-50" : "text-muted";
    messageTime.style.fontSize = "11px";
    messageTime.textContent = new Date(msg.created_at).toLocaleTimeString(
        "id-ID",
        {
            hour: "2-digit",
            minute: "2-digit",
        }
    );

    messageBubble.appendChild(messageText);
    messageBubble.appendChild(messageTime);
    messageWrapper.appendChild(messageBubble);

    return messageWrapper;
}

/**
 * Refresh chat with new messages
 */
function refreshChat(data) {
    emptyState.style.display = "none";

    if (!data.messages || data.messages.length === 0) {
        if (messagesDiv.children.length <= 1) {
            messagesDiv.innerHTML = `
                <div class="text-center text-muted py-5">
                    <i class="bi bi-chat-left-dots display-4 d-block mb-3"></i>
                    <p>Belum ada pesan. Mulai percakapan!</p>
                </div>
            `;
        }
        return;
    }

    if (data.messages.length === lastMessageCount) {
        return;
    }

    const existingMessageIds = Array.from(
        messagesDiv.querySelectorAll("[data-message-id]")
    ).map((el) => el.dataset.messageId);

    let hasNewIncomingMessage = false;
    let newMessageInfo = null;

    data.messages.forEach((msg) => {
        if (!existingMessageIds.includes(msg.id.toString())) {
            const messageElement = renderMessage(msg, true);
            messagesDiv.appendChild(messageElement);

            // Check if this is an incoming message (not from psikolog)
            if (
                msg.sender_id != psikologId &&
                !lastMessageIds.has(msg.id.toString())
            ) {
                hasNewIncomingMessage = true;
                newMessageInfo = {
                    userName: data.userName || chatUsername.textContent,
                    message: msg.message,
                };
            }

            lastMessageIds.add(msg.id.toString());
        }
    });

    // Show notification for new incoming messages
    if (hasNewIncomingMessage && newMessageInfo) {
        playNotificationSound();
        showToast(newMessageInfo.message, newMessageInfo.userName, "warning");
        showBrowserNotification(
            newMessageInfo.userName,
            newMessageInfo.message
        );
    }

    lastMessageCount = data.messages.length;

    if (isAtBottom) {
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
}

/**
 * Load initial chat
 */
function loadChat(userId) {
    fetch(`/psikolog/chat/${userId}`)
        .then((r) => r.json())
        .then((data) => {
            messagesDiv.innerHTML = "";
            emptyState.style.display = "none";
            lastMessageIds.clear();

            if (!data.messages || data.messages.length === 0) {
                messagesDiv.innerHTML = `
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-chat-left-dots display-4 d-block mb-3"></i>
                        <p>Belum ada pesan. Mulai percakapan!</p>
                    </div>
                `;
                lastMessageCount = 0;
            } else {
                data.messages.forEach((msg) => {
                    const messageElement = renderMessage(msg, false);
                    messagesDiv.appendChild(messageElement);
                    lastMessageIds.add(msg.id.toString());
                });
                lastMessageCount = data.messages.length;
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }
        })
        .catch((err) => console.error("Error loading chat:", err));
}

/**
 * Initialize chat user click handlers
 */
function initChatUserHandlers() {
    chatUsers.forEach((user) => {
        user.addEventListener("click", function () {
            chatUsers.forEach((u) => u.classList.remove("active"));
            this.classList.add("active");

            activeUserId = this.dataset.userId;
            const userName = this.dataset.userName;

            chatHeader.style.display = "block";
            chatUsername.textContent = userName;
            chatAvatar.textContent = userName.charAt(0).toUpperCase();

            messageInput.disabled = false;
            sendBtn.disabled = false;
            messageInput.focus();

            // Remove unread badge when opening chat
            const unreadBadge = this.querySelector(".unread-badge");
            if (unreadBadge) {
                unreadBadge.style.display = "none";
            }

            loadChat(activeUserId);

            // Clear previous active chat polling
            if (activeChatPollInterval) clearInterval(activeChatPollInterval);

            // Start polling for active chat (faster refresh)
            activeChatPollInterval = setInterval(() => {
                if (activeUserId) {
                    fetch(`/psikolog/chat/${activeUserId}`)
                        .then((r) => r.json())
                        .then((data) => refreshChat(data))
                        .catch((err) =>
                            console.error("Error polling active chat:", err)
                        );
                }
            }, 3000);
        });
    });
}

/**
 * Initialize message form
 */
function initMessageForm() {
    messageForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const text = messageInput.value.trim();
        if (!text || !activeUserId) return;

        sendBtn.disabled = true;

        fetch("/psikolog/chat/send", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                receiver_id: activeUserId,
                message: text,
            }),
        })
            .then((r) => r.json())
            .then((data) => {
                messageInput.value = "";
                sendBtn.disabled = false;
                messageInput.focus();
                loadChat(activeUserId);
            })
            .catch((err) => {
                console.error("Error sending message:", err);
                sendBtn.disabled = false;
                alert("Gagal mengirim pesan. Coba lagi.");
            });
    });
}

/**
 * Check all patients for new messages
 */
function checkAllPatientsForNewMessages() {
    const allUserIds = Array.from(chatUsers).map((user) => user.dataset.userId);

    allUserIds.forEach((userId) => {
        fetch(`/psikolog/chat/${userId}`)
            .then((r) => r.json())
            .then((data) => {
                if (!data.messages || data.messages.length === 0) return;

                // Check for new incoming messages from this patient
                data.messages.forEach((msg) => {
                    const messageId = msg.id.toString();

                    // If message is new and from patient (not from psikolog)
                    if (
                        !globalLastMessageIds.has(messageId) &&
                        msg.sender_id != psikologId
                    ) {
                        // Show notification only if not currently viewing this chat
                        if (userId !== activeUserId) {
                            const userName =
                                data.userName ||
                                Array.from(chatUsers).find(
                                    (u) => u.dataset.userId === userId
                                )?.dataset.userName ||
                                "Pasien";
                            playNotificationSound();
                            showToast(msg.message, userName, "warning");
                            showBrowserNotification(userName, msg.message);

                            // Add unread indicator to patient list item
                            const patientItem = document.querySelector(
                                `[data-user-id="${userId}"]`
                            );
                            if (patientItem) {
                                const unreadBadge =
                                    patientItem.querySelector(".unread-badge");
                                if (unreadBadge) {
                                    unreadBadge.style.display = "block";
                                }
                            }
                        }
                    }

                    globalLastMessageIds.add(messageId);
                });
            })
            .catch((err) =>
                console.error("Error checking patient messages:", err)
            );
    });
}

/**
 * Initialize global message tracking
 */
function initializeGlobalMessageTracking() {
    const allUserIds = Array.from(chatUsers).map((user) => user.dataset.userId);

    let completedRequests = 0;
    const totalRequests = allUserIds.length;

    allUserIds.forEach((userId) => {
        fetch(`/psikolog/chat/${userId}`)
            .then((r) => r.json())
            .then((data) => {
                if (data.messages) {
                    data.messages.forEach((msg) => {
                        globalLastMessageIds.add(msg.id.toString());
                    });
                }
                completedRequests++;

                // Start global polling after all initial data is loaded
                if (completedRequests === totalRequests) {
                    console.log("✅ Global message tracking initialized");
                    // Start global polling (slower refresh for all patients)
                    globalPollInterval = setInterval(
                        checkAllPatientsForNewMessages,
                        5000
                    );
                }
            })
            .catch((err) => {
                console.error("Error initializing:", err);
                completedRequests++;

                // Still start polling even if some requests fail
                if (completedRequests === totalRequests) {
                    globalPollInterval = setInterval(
                        checkAllPatientsForNewMessages,
                        5000
                    );
                }
            });
    });
}

/**
 * Cleanup on page unload
 */
function cleanupOnUnload() {
    window.addEventListener("beforeunload", function () {
        if (globalPollInterval) clearInterval(globalPollInterval);
        if (activeChatPollInterval) clearInterval(activeChatPollInterval);
    });
}

/**
 * Initialize all chat functionality
 */
function initChat() {
    if (!psikologId) {
        console.error("❌ Psikolog ID not found");
        return;
    }

    if (!csrfToken) {
        console.error("❌ CSRF Token not found");
        return;
    }

    // Initialize all components
    requestNotificationPermission();
    initSoundToggle();
    initSearchPatient();
    initScrollDetection();
    initChatUserHandlers();
    initMessageForm();
    cleanupOnUnload();

    // Initialize global message tracking if there are patients
    if (chatUsers.length > 0) {
        initializeGlobalMessageTracking();
    } else {
        console.log("⚠️ No patients found");
    }

    console.log("✅ Chat initialized");
}

// Initialize when DOM is ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initChat);
} else {
    initChat();
}
