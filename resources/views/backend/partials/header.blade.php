<header class="admin-header">

    <div class="admin-header-left">

        <button
            type="button"
            class="admin-sidebar-toggle"
            id="adminSidebarToggle"
            aria-label="Open sidebar"
        >
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="admin-page-heading">

            <h1>
                @yield('page-title', 'Dashboard')
            </h1>

            <p>
                @yield(
                    'page-description',
                    'Manage your website content and enquiries'
                )
            </p>

        </div>

    </div>

    <div class="admin-header-right">

        <button
            type="button"
            class="admin-header-icon-button"
            title="Notifications"
        >
            <i class="fa-regular fa-bell"></i>

            <span class="admin-notification-dot"></span>
        </button>

        <div class="admin-profile">

            <div class="admin-profile-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="admin-profile-details">

                <strong>
                    {{ auth()->user()->name }}
                </strong>

                <span>
                    Administrator
                </span>

            </div>

        </div>

        <form
            action="{{ route('admin.logout') }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="admin-logout-button"
                onclick="return confirm('Are you sure you want to logout?')"
            >
                <i class="fa-solid fa-arrow-right-from-bracket"></i>

                <span>Logout</span>
            </button>

        </form>

    </div>

</header>