document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("adminSidebar");
    const toggleButton = document.getElementById("adminSidebarToggle");
    const overlay = document.getElementById("adminSidebarOverlay");

    function openSidebar() {
        sidebar?.classList.add("active");
        overlay?.classList.add("active");
        document.body.classList.add("admin-sidebar-open");
    }

    function closeSidebar() {
        sidebar?.classList.remove("active");
        overlay?.classList.remove("active");
        document.body.classList.remove("admin-sidebar-open");
    }

    toggleButton?.addEventListener("click", function () {
        if (sidebar?.classList.contains("active")) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    overlay?.addEventListener("click", closeSidebar);

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeSidebar();
        }
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 991) {
            closeSidebar();
        }
    });
});

