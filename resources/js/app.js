import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// normal messaging (new bokk, new exam .....)
if (window.App?.userId) {
    window.Echo.private(`App.Models.User.${window.App.userId}`)
        .notification((notification) => {
            console.log('Realtime notification:', notification)

            const badge = document.getElementById('notif-badge')
            const dot = document.getElementById('notif-dot')
            const list = document.getElementById('notif-list')

            // bump badge
            if (badge) {
                const next = Number((badge.textContent || '0').trim()) + 1
                badge.textContent = next
            }
            // show the dot
            if (dot) dot.classList.remove('d-none')

            // prepend a new item
            if (list) {
                const item = document.createElement('div')
                item.className = 'notification-content'
                item.innerHTML = `
          <a href="${notification.url ?? '#'}" class="notification-info text-end">
            <p class="mb-0 fw-bold">
              ${(notification.message ?? 'Notification')} - ${(notification.title ?? '')}
            </p>
          </a>
          <span class="fw-bold">just now</span>
        `
                list.prepend(item)
            }
        })
}



// Chatify (messaging)
if (window.authUserId) {
    window.Echo.private(`chatify.${window.authUserId}`)
        .listen('.messaging', (e) => {
            console.log("📩 Chat message received:", e);

            const chatUserName = document.getElementById('chatUserName');
            const chatBody = document.getElementById('chatBody');

            if (chatUserName && chatUserName.dataset.userid == e.from_id) {
                // المستخدم فاتح المحادثة مع المرسل
                let div = document.createElement('div');
                div.classList.add('chat-msg-reply');
                div.innerHTML = `
                    <div class="bubble">
                        <p>${e.message}</p>
                        <span class="time">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                    </div>`;
                chatBody.appendChild(div);
                chatBody.scrollTop = chatBody.scrollHeight;
            } else {
                // 👇 عرض مؤشر أو نقطة فوق أيقونة الرسائل
                const msgDot = document.getElementById("msgNotifDot");
                if (msgDot) msgDot.style.display = "block";
            }
        });
}

