<aside class="admin-sidebar" id="adminSidebar">

    <div class="admin-logo">

        <div class="admin-logo-mark">
            G
        </div>

        <div class="admin-logo-content">
            <h2>GenBright</h2>
            <p>Admin Panel</p>
        </div>

    </div>

    <nav class="admin-sidebar-menu">

        <p class="admin-menu-title">
            Main Menu
        </p>

        <a href="{{ route('admin.dashboard') }}"
            class="admin-menu-link
            {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-house"></i>
            </span>

            <span>Dashboard</span>
        </a>

        <p class="admin-menu-title">
            Website Management
        </p>

        <a href="javascript:void(0)" class="admin-menu-link">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-images"></i>
            </span>

            <span>Media</span>
        </a>

        <a href="javascript:void(0)" class="admin-menu-link">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-school"></i>
            </span>

            <span>Campus</span>
        </a>

        <a href="javascript:void(0)" class="admin-menu-link">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-book-open"></i>
            </span>

            <span>Programs</span>
        </a>

        <a href="javascript:void(0)" class="admin-menu-link">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-user-graduate"></i>
            </span>

            <span>Admissions</span>
        </a>

        <a href="javascript:void(0)" class="admin-menu-link">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-envelope"></i>
            </span>

            <span>Enquiries</span>
        </a>

        <p class="admin-menu-title">
            Content
        </p>

        <a href="javascript:void(0)" class="admin-menu-link">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-image"></i>
            </span>

            <span>Home Banner</span>
        </a>

        <li class="nav-item">

            <a href="{{ route('admin.video-sections.index') }}"
                class="nav-link
            {{ request()->routeIs('admin.video-sections.*') ? 'active' : '' }}">

                <span>
                    Video Sections
                </span>

            </a>

        </li>

        <a href="javascript:void(0)" class="admin-menu-link">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-comment"></i>
            </span>

            <span>Testimonials</span>
        </a>

        <p class="admin-menu-title">
            Settings
        </p>

        <a href="javascript:void(0)" class="admin-menu-link">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-gear"></i>
            </span>

            <span>Website Settings</span>
        </a>

        <a href="javascript:void(0)" class="admin-menu-link">
            <span class="admin-menu-icon">
                <i class="fa-solid fa-user-shield"></i>
            </span>

            <span>Admin Profile</span>
        </a>

    </nav>

</aside>

<div class="admin-sidebar-overlay" id="adminSidebarOverlay"></div>
