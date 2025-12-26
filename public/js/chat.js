document.addEventListener("DOMContentLoaded", function () {
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

    const audioContext = new (window.AudioContext || window.webkitAudioContext)();

    function playNotificationSound() {
        if (!notificationSound) return;
        if (audioContext.state === "suspended") audioContext.resume();

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

    document.body.addEventListener("click", () => {
        if (audioContext.state === "suspended") audioContext.resume();
    }, { once: true });

    if (soundToggle) {
        soundToggle.addEventListener("click", () => {
            notificationSound = !notificationSound;
            const icon = soundToggle.querySelector("i");
            if (notificationSound) {
                icon.className = "bi bi-bell-fill text-success fs-5";
                playNotificationSound();
            } else {
                icon.className = "bi bi-bell-slash-fill text-muted fs-5";
            }
        });
    }

    function showToast(title, message) {
        const toast = document.createElement("div");
        toast.className = "toast-notification";
        toast.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <div class="bg-success rounded-circle p-2 text-white d-flex align-items-center justify-content-center" style="width:32px;height:32px">
                    <i class="bi bi-chat-dots-fill" style="font-size:0.8rem"></i>
                </div>
                <div class="overflow-hidden">
                    <strong class="d-block text-dark text-truncate" style="font-size:0.9rem">${title}</strong>
                    <small class="text-muted text-truncate d-block" style="max-width: 250px;">${message}</small>
                </div>
            </div>
        `;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.transform = "translateX(0)";
            toast.style.opacity = "1";
        }, 10);
        setTimeout(() => {
            toast.style.opacity = "0";
            toast.style.transform = "translateX(100%)";
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    function scrollToBottom() {
        if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
    }

    function appendMessageToDOM(msg, type) {
        if (!chatBox) return;
        if (emptyState) emptyState.style.display = "none";

        const isMe = type === "outgoing";
        const time = new Date(msg.created_at || new Date()).toLocaleTimeString("id-ID", { hour: "2-digit", minute: "2-digit" });

        let readIcon = "";
        if (isMe) {
            const statusClass = msg.is_read == 1 || msg.is_read === true ? "read" : "unread";
            const msgId = msg.id || Date.now();
            readIcon = `<i class="bi bi-check-all read-icon ${statusClass}" id="msg-check-${msgId}"></i>`;
        }

        const html = `
            <div class="d-flex mb-3 ${isMe ? "justify-content-end" : "justify-content-start"}">
                <div class="message-bubble rounded-3 px-3 py-2 shadow-sm ${isMe ? "chat-me text-white" : "bg-white border text-dark"}">
                    <div class="message-text">${msg.message}</div>
                    <div class="d-flex justify-content-end align-items-center mt-1 gap-1">
                        <small class="${isMe ? "text-white-50" : "text-muted"}" style="font-size: 0.65rem;">${time}</small>
                        ${readIcon}
                    </div>
                </div>
            </div>`;

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
                const icon = isOutgoing ? `<i id="sidebar-check-${userId}" class="bi bi-check-all me-1"></i> ` : "";
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
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ sender_id: senderId }),
        }).catch(console.error);
    }

    function loadChatHistory(userId) {
        chatBox.innerHTML = '<div class="text-center py-5 text-muted"><div class="spinner-border spinner-border-sm" role="status"></div> Memuat...</div>';

        fetch(`/psikolog/chat/get/${userId}`)
            .then((r) => r.json())
            .then((data) => {
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
            })
            .catch(() => (chatBox.innerHTML = '<div class="text-center text-danger">Gagal memuat pesan.</div>'));
    }

    if (patientList) {
        patientList.addEventListener("click", function (e) {
            const item = e.target.closest(".chat-user-item");
            if (!item) return;

            document.querySelectorAll(".chat-user-item").forEach((i) => i.classList.remove("active"));
            item.classList.add("active");

            activeUserId = item.dataset.userId;
            const userName = item.dataset.userName;
            const isOnline = item.dataset.userStatus == "1";

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
            if (chatAvatar) chatAvatar.innerText = userName.charAt(0).toUpperCase();
            if (chatUserStatus) {
                chatUserStatus.innerHTML = isOnline
                    ? '<i class="bi bi-circle-fill text-success" style="font-size: 6px;"></i> Online'
                    : '<i class="bi bi-circle-fill text-secondary" style="font-size: 6px;"></i> Offline';
            }

            if (messageInput) {
                messageInput.disabled = false;
                messageInput.focus();
            }
            if (sendBtn) sendBtn.disabled = false;

            loadChatHistory(activeUserId);
        });
    }

    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const text = messageInput.value.trim();
            if (!text || !activeUserId) return;

            const tempId = Date.now();
            const tempMsg = {
                id: tempId,
                message: text,
                created_at: new Date(),
                sender_id: psikologId,
                is_read: 0,
            };

            appendMessageToDOM(tempMsg, "outgoing");
            updateSidebarPreview(activeUserId, text, true);
            messageInput.value = "";

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
                    const icon = document.getElementById(`msg-check-${tempId}`);
                    if (icon) icon.id = `msg-check-${data.id}`;
                });
        });
    }

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll(".chat-user-item").forEach((item) => {
                const name = item.dataset.userName.toLowerCase();
                item.style.display = name.includes(term) ? "block" : "none";
            });
        });
    }

    if (typeof Echo !== "undefined") {
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
                    showToast(name, e.chat.message);
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
                    sidebarIcon.classList.add("text-primary");
                }
            });

        window.Echo.join("presence-chat")
            .listen(".user.status", (e) => {
                const item = document.querySelector(`.chat-user-item[data-user-id="${e.userId}"]`);
                if (item) {
                    item.dataset.userStatus = e.status;
                    const dot = document.getElementById(`status-dot-${e.userId}`);
                    if (dot) e.status == 1 ? dot.classList.add("online") : dot.classList.remove("online");

                    if (activeUserId == e.userId && chatUserStatus) {
                        chatUserStatus.innerHTML = e.status == 1
                            ? '<i class="bi bi-circle-fill text-success" style="font-size: 6px;"></i> Online'
                            : '<i class="bi bi-circle-fill text-secondary" style="font-size: 6px;"></i> Offline';
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
            })
            .joining((u) => {
                const dot = document.getElementById(`status-dot-${u.id}`);
                if (dot) dot.classList.add("online");
            })
            .leaving((u) => {
                const dot = document.getElementById(`status-dot-${u.id}`);
                if (dot) dot.classList.remove("online");
            });
    }
});