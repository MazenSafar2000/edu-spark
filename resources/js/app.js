import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

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

