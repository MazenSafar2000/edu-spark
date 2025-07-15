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


// القائمة المنسدلة للطلاب فيي الساييد بار

document.addEventListener("DOMContentLoaded", function () {
    const toggleLink = document.querySelector(".dropdown-toggle-custom");
    const target = document.querySelector("#studentsMenu");
    const toggleIcon = toggleLink.querySelector(".toggle-icon");

    // عند الضغط: نتوقع الحالة القادمة
    toggleLink.addEventListener("click", function (e) {
        const willOpen = !target.classList.contains("show");

        if (willOpen) {
            toggleIcon.classList.remove("fa-plus");
            toggleIcon.classList.add("fa-minus");
        }
    });

    // عند الإغلاق النهائي: نرجّع الأيقونة إلى زائد
    target.addEventListener("hidden.bs.collapse", function () {
        toggleIcon.classList.remove("fa-minus");
        toggleIcon.classList.add("fa-plus");
    });
});
