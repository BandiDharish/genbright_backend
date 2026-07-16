<aside class="admin-sidebar" id="adminSidebar">

    <div class="admin-logo">
        <div class="admin-logo-mark">G</div>

        <div class="admin-logo-content">
            <h2>GenBright</h2>
            <p>Admin Panel</p>
        </div>
    </div>

    <nav class="admin-sidebar-menu">

        <p class="admin-menu-title">Main Menu</p>

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="admin-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-house"></i>
            </span>
            <span>Dashboard</span>
        </a>

        <!-- Contact Enquiries -->
        <a href="{{ route('admin.contacts.index') }}"
            class="admin-menu-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-users"></i>
            </span>
            <span>Users</span>
        </a>

        <!-- Video Sections -->
        <a href="{{ route('admin.video-sections.index') }}"
            class="admin-menu-link {{ request()->routeIs('admin.video-sections.*') ? 'active' : '' }}">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-video"></i>
            </span>
            <span>Video Sections</span>
        </a>

    </nav>

</aside>

<div class="admin-sidebar-overlay" id="adminSidebarOverlay"></div>