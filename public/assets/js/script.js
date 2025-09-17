
(function () {
    const menu = document.getElementById('mainNavbar');
    const toggle = document.querySelector('.navbar-toggler');
    const langBtn = document.querySelector('.lang-switcher .lang-dropdown');
    const langItem = document.querySelector('.lang-switcher');

    // فتح/إغلاق القائمة الرئيسية
    toggle && toggle.addEventListener('click', function () {
        const isOpen = menu.classList.toggle('show');
        this.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    // فتح/إغلاق قائمة اللغة على الموبايل فقط
    if (langBtn) {
        langBtn.addEventListener('click', function (e) {
            // على الشاشات الصغيرة فقط
            if (window.matchMedia('(max-width: 991.98px)').matches) {
                e.preventDefault();
                langItem.classList.toggle('show');
            }
        });
    }

    // إغلاق أي شيء مفتوح عند الضغط خارج القوائم
    document.addEventListener('click', function (e) {
        const clickInsideMenu = menu.contains(e.target) || (toggle && toggle.contains(e.target));
        if (!clickInsideMenu) {
            menu.classList.remove('show');
            toggle && toggle.setAttribute('aria-expanded', 'false');
        }
        if (langItem && !langItem.contains(e.target)) {
            langItem.classList.remove('show');
        }
    });
})();


//   اظهار واخفاء السايد بار من خلال الضغط على اييقونة القائمة
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");
    const closeBtn = document.getElementById("closeSidebar");
    const mainContent = document.getElementById("mainContent");

    function toggleSidebar() {
        const isHidden = sidebar.classList.contains("hidden");
        sidebar.classList.toggle("hidden");
        mainContent.classList.toggle("with-sidebar", isHidden);
        mainContent.classList.toggle("no-sidebar", !isHidden);
    }

    toggle.addEventListener("click", function (e) {
        e.preventDefault();
        toggleSidebar();
    });

    closeBtn.addEventListener("click", function () {
        sidebar.classList.add("hidden");
        mainContent.classList.remove("with-sidebar");
        mainContent.classList.add("no-sidebar");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("sidebarToggle");
    const sidebarStd = document.getElementById("sidebarStd");
    const closeBtn = document.getElementById("closeSidebar");
    const mainContent = document.getElementById("mainContent");

    function toggleSidebar() {
        const isHidden = sidebarStd.classList.contains("hidden");
        sidebarStd.classList.toggle("hidden");
        mainContent.classList.toggle("with-sidebarStd", isHidden);
        mainContent.classList.toggle("no-sidebarStd", !isHidden);
    }

    toggle.addEventListener("click", function (e) {
        e.preventDefault();
        toggleSidebar();
    });

    closeBtn.addEventListener("click", function () {
        sidebarStd.classList.add("hidden");
        mainContent.classList.remove("with-sidebarStd");
        mainContent.classList.add("no-sidebarStd");
    });
});


//   اظهار واخفاء السايد بار عند تصغير الشاشة
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.createElement("div");
    const toggleBtn = document.getElementById("sidebarToggle");

    // إنشاء الـ overlay إذا مش موجود
    overlay.id = "overlay";
    document.body.appendChild(overlay);

    // إظهار السايدبار والـ overlay
    toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("active");
        overlay.classList.toggle("active");
    });

    // إغلاق عند الضغط على الخلفية
    overlay.addEventListener("click", function () {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const sidebarStd = document.querySelector(".sidebarStd");
    const overlayStd = document.createElement("div");
    const toggleBtn = document.getElementById("sidebarToggle");

    // إنشاء الـ overlay إذا مش موجود
    overlayStd.id = "overlayStd";
    document.body.appendChild(overlayStd);

    // إظهار السايدبار والـ overlay
    toggleBtn.addEventListener("click", function () {
        sidebarStd.classList.toggle("active");
        overlayStd.classList.toggle("active");
    });

    // إغلاق عند الضغط على الخلفية
    overlay.addEventListener("click", function () {
        sidebarStd.classList.remove("active");
        overlayStd.classList.remove("active");
    });
});

// كلاس ال active على السايد بار
document.querySelectorAll('.sidebar a').forEach(link => {
    if (link.href === window.location.href) {
        link.classList.add('active');
    }
});


// التقويم في سايد بار الطالب
document.addEventListener("DOMContentLoaded", function () {
    const miniMonthNames = ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];
    const miniWeekDays = ["ح", "ن", "ث", "ر", "خ", "ج", "س"];
    let miniDate = new Date();

    function renderMiniCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        const header = document.getElementById("mini-month-year");
        const grid = document.getElementById("mini-calendar-grid");

        if (!header || !grid) return; // تأكيد وجود العناصر

        header.textContent = `${miniMonthNames[month]} ${year}`;
        grid.innerHTML = "";

        miniWeekDays.forEach(d => {
            const day = document.createElement("div");
            day.innerHTML = `<strong>${d}</strong>`;
            grid.appendChild(day);
        });

        for (let i = 0; i < firstDay; i++) {
            grid.appendChild(document.createElement("div"));
        }

        const today = new Date();
        for (let day = 1; day <= daysInMonth; day++) {
            const cell = document.createElement("div");
            cell.textContent = day;

            if (
                day === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()
            ) {
                cell.classList.add("today");
            }

            grid.appendChild(cell);
        }
    }

    function changeMonth(offset) {
        miniDate.setMonth(miniDate.getMonth() + offset);
        renderMiniCalendar(miniDate);
    }

    renderMiniCalendar(miniDate);
});

// الانتقال بين النماذج فيي صفحات اللوقن
function showForm(type, clickedIcon) {
    const formGroups = {
        student: {
            show: "stdForm",
            hide: "parentForm",
            activeImg: "/assets/images/std-on.png",
            inactiveImg: "/assets/images/par-off.png",
            activeIcon: "icon-std",
            inactiveIcon: "icon-parent"
        },
        parent: {
            show: "parentForm",
            hide: "stdForm",
            activeImg: "/assets/images/par-on.png",
            inactiveImg: "/assets/images/std-off.png",
            activeIcon: "icon-parent",
            inactiveIcon: "icon-std"
        },
        teacher: {
            show: "teacherForm",
            hide: "adminForm",
            activeImg: "/assets/images/teacher.png",
            inactiveImg: "/assets/images/manager-off.png",
            activeIcon: "icon-teacher",
            inactiveIcon: "icon-admin"
        },
        admin: {
            show: "adminForm",
            hide: "teacherForm",
            activeImg: "/assets/images/manager.png",
            inactiveImg: "/assets/images/teacher-off.png",
            activeIcon: "icon-admin",
            inactiveIcon: "icon-teacher"
        }
    };

    // التأكد إن النوع صحيح
    if (!formGroups[type]) return;

    const group = formGroups[type];
    const showFormEl = document.getElementById(group.show);
    const hideFormEl = document.getElementById(group.hide);
    const activeIconImg = document.getElementById(group.activeIcon).querySelector("img");
    const inactiveIconImg = document.getElementById(group.inactiveIcon).querySelector("img");

    hideFormEl.style.display = "none";
    showFormEl.style.display = "block";
    showFormEl.classList.add("fade-in");

    activeIconImg.src = group.activeImg;
    inactiveIconImg.src = group.inactiveImg;

    document.querySelectorAll('.icon, .login-icon').forEach(icon => {
        icon.classList.remove('active-icon');
    });
    clickedIcon.classList.add('active-icon');
}

// القائمة المنسدلة للطلاب فيي الساييد بار
document.addEventListener("DOMContentLoaded", function () {
    const toggleLink = document.querySelector(".dropdown-toggle-custom");
    const menu = document.querySelector("#studentsMenu");
    const icon = toggleLink.querySelector(".toggle-icon");

    toggleLink.addEventListener("click", function (e) {
        e.preventDefault();

        if (menu.style.maxHeight) {
            // القائمة مفتوحة → أغلقها
            menu.style.maxHeight = null;
            icon.classList.remove("fa-minus");
            icon.classList.add("fa-plus");
        } else {
            // القائمة مغلقة → افتحها
            menu.style.maxHeight = menu.scrollHeight + "px";
            icon.classList.remove("fa-plus");
            icon.classList.add("fa-minus");
        }
    });
});

const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// get messages using pusher
if (window.authUserId) {
    window.Echo.private(`chatify.${window.authUserId}`)
        .listen('.messaging', (e) => {
            const chatUserName = document.getElementById('chatUserName');
            const chatBody = document.getElementById('chatBody');

            if (chatUserName && chatUserName.dataset.userid == e.from_id) {
                // مستخدم فاتح المحادثة
                appendMessage(e, false);
            } else {
                // 👇 أظهر نقطة حمراء
                document.getElementById("msgNotifDot").classList.remove("d-none");

                // 👇 (اختياري) Toast Notification
                const toast = document.createElement("div");
                toast.className = "toast align-items-center text-bg-primary border-0 show";
                toast.innerHTML = `
              <div class="d-flex">
                <div class="toast-body">
                  رسالة جديدة من ${e.sender_name}: ${e.message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
              </div>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 5000);
            }
        });

}

// open a chat
function openChatPopup(userId, userName) {
    const chatUserName = document.getElementById("chatUserName");
    const popup = document.getElementById("chatPopup");
    const offcanvasEl = document.getElementById('messagesOffcanvas');
    const chatBody = document.getElementById("chatBody");

    chatUserName.innerText = userName;
    chatUserName.dataset.userid = userId;

    popup.style.display = "block";
    requestAnimationFrame(() => popup.classList.add("is-open"));

    if (window.bootstrap && offcanvasEl) {
        let inst = bootstrap.Offcanvas.getInstance(offcanvasEl);
        if (!inst) inst = new bootstrap.Offcanvas(offcanvasEl);
        inst.hide();
    }

    setTimeout(() => {
        const input = document.querySelector(".chat-input");
        input && input.focus();
    }, 80);

    // fetch old messages
    fetch('/custom/messages', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            id: userId   // هذا الـ id لازم يكون الـ users.id تبع الشخص اللي معاه المحادثة
        })
    })
        .then(res => res.json())
        .then(messages => {
            chatBody.innerHTML = '';

            messages.forEach(msg => {
                let div = document.createElement("div");
                div.classList.add(
                    msg.from_id === window.authUserId
                        ? "chat-msg-user"
                        : "chat-msg-reply"
                );
                div.innerHTML = `
            <div class="bubble">
                <p>${msg.body}</p>
                <span class="time">${new Date(msg.created_at)
                        .toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
            </div>
        `;
                chatBody.appendChild(div);
            });

            chatBody.scrollTop = chatBody.scrollHeight;
        });

    fetch('/custom/markAsRead', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            from_id: userId
        })
    });

}

// send message
function sendMessage(event) {
    if (event.key === 'Enter') {
        let input = event.target;
        let message = input.value;
        let userId = document.getElementById('chatUserName').dataset.userid;

        if (message.trim() !== '') {
            fetch('/chatify/sendMessage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    id: userId,
                    type: 'user',
                    message: message
                })
            })
                .then(res => res.json())
                .then(() => {
                    let chatBody = document.getElementById('chatBody');
                    let div = document.createElement('div');
                    div.classList.add('chat-msg-user');
                    div.innerHTML = `
                        <div class="bubble">
                            <p>${message}</p>
                            <span class="time">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                        </div>`;
                    chatBody.appendChild(div);

                    chatBody.scrollTop = chatBody.scrollHeight;
                    input.value = '';
                });
        }
    }
}

// close popup
function closeChatPopup() {
    const popup = document.getElementById("chatPopup");
    popup.classList.remove("is-open");

    const done = () => {
        popup.style.display = "none";
        popup.removeEventListener("transitionend", done);
    };
    popup.addEventListener("transitionend", done, { once: true });
    setTimeout(done, 300);
}

// ✅ البحث عن المستخدمين
function filterUsers(input) {
    const filter = input.value.toLowerCase();
    document.querySelectorAll('.message-item').forEach(item => {
        const name = item.innerText.toLowerCase();
        item.style.display = name.includes(filter) ? '' : 'none';
    });
}



document.querySelectorAll('.unit-header').forEach(header => {
    header.addEventListener('click', () => {
        const unit = header.parentElement;
        unit.classList.toggle('open');
    });
});







