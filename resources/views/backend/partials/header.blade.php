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

        <div class="admin-profile-dropdown" id="adminProfileDropdown">

            <button
                type="button"
                class="admin-profile-trigger"
                id="adminProfileTrigger"
                aria-expanded="false"
                aria-haspopup="true"
            >
                <div class="admin-profile-avatar" id="headerProfileAvatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="admin-profile-details">
                    <strong id="headerProfileName">
                        {{ auth()->user()->name }}
                    </strong>
                    <span>
                        Administrator
                        <i class="fa-solid fa-chevron-down dropdown-caret"></i>
                    </span>
                </div>
            </button>

            <div class="admin-profile-menu" id="adminProfileMenu">
                <div class="admin-profile-menu-header">
                    <strong id="dropdownMenuName">
                        {{ auth()->user()->name }}
                    </strong>
                    <span class="admin-profile-menu-email" id="dropdownMenuEmail">
                        {{ auth()->user()->email }}
                    </span>
                </div>

                <div class="admin-profile-menu-divider"></div>

                <button
                    type="button"
                    class="admin-profile-menu-item"
                    id="openProfileBtn"
                >
                    <i class="fa-regular fa-user"></i>
                    <span>My Profile</span>
                </button>

                <button
                    type="button"
                    class="admin-profile-menu-item"
                    id="openSettingsBtn"
                >
                    <i class="fa-solid fa-gear"></i>
                    <span>Settings</span>
                </button>

                <div class="admin-profile-menu-divider"></div>

                <form
                    action="{{ route('admin.logout') }}"
                    method="POST"
                    id="adminLogoutForm"
                >
                    @csrf
                    <button
                        type="submit"
                        class="admin-profile-menu-item logout-btn"
                        onclick="return confirm('Are you sure you want to logout?')"
                    >
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>

        </div>

    </div>

    <!-- My Profile Modal -->
    <div class="admin-modal" id="profileModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="admin-modal-overlay" data-close-modal></div>
        <div class="admin-modal-container">
            <div class="admin-modal-header">
                <h3 class="admin-modal-title">My Profile</h3>
                <button type="button" class="admin-modal-close" data-close-modal aria-label="Close modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="admin-modal-body">
                <div class="profile-card-modal">
                    <div class="profile-avatar-large" id="modalProfileAvatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="profile-info-group">
                        <label>Full Name</label>
                        <div class="profile-info-value" id="profileNameDisplay">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="profile-info-group">
                        <label>Email Address</label>
                        <div class="profile-info-value" id="profileEmailDisplay">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="profile-info-group">
                        <label>Role</label>
                        <div class="profile-info-value">Administrator</div>
                    </div>
                </div>
            </div>
            <div class="admin-modal-footer">
                <button type="button" class="admin-btn admin-btn-secondary" data-close-modal>Close</button>
                <button type="button" class="admin-btn admin-btn-primary" id="switchToSettingsBtn">Edit Profile</button>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div class="admin-modal" id="settingsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="admin-modal-overlay" data-close-modal></div>
        <div class="admin-modal-container">
            <div class="admin-modal-header">
                <h3 class="admin-modal-title">Profile Settings</h3>
                <button type="button" class="admin-modal-close" data-close-modal aria-label="Close modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form id="profileSettingsForm" action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="admin-modal-body">
                    <div class="alert admin-alert admin-alert-danger d-none" id="settingsFormError"></div>

                    <div class="form-group-custom">
                        <label for="settingsEmail">Email Address <span class="required-star">*</span></label>
                        <input
                            type="email"
                            id="settingsEmail"
                            name="email"
                            value="{{ auth()->user()->email }}"
                            required
                            class="form-control-custom"
                        >
                        <span class="error-msg" id="error-email"></span>
                    </div>

                    <div class="form-divider-custom"><span>Change Password</span></div>
                    <p class="form-note-custom">Leave password fields blank if you do not want to change your password.</p>

                    <div class="form-group-custom">
                        <label for="settingsNewPassword">New Password</label>
                        <input
                            type="password"
                            id="settingsNewPassword"
                            name="new_password"
                            placeholder="Enter new password"
                            class="form-control-custom"
                        >
                        <span class="error-msg" id="error-new_password"></span>
                    </div>

                    <div class="form-group-custom">
                        <label for="settingsConfirmPassword">Confirm New Password</label>
                        <input
                            type="password"
                            id="settingsConfirmPassword"
                            name="new_password_confirmation"
                            placeholder="Confirm new password"
                            class="form-control-custom"
                        >
                        <span class="error-msg" id="error-new_password_confirmation"></span>
                    </div>

                    <div class="form-divider-custom"><span>Verification</span></div>

                    <div class="form-group-custom">
                        <label for="settingsCurrentPassword">Current Password <span class="required-star">*</span></label>
                        <input
                            type="password"
                            id="settingsCurrentPassword"
                            name="current_password"
                            placeholder="Enter current password to save changes"
                            required
                            class="form-control-custom"
                        >
                        <span class="error-msg" id="error-current_password"></span>
                    </div>
                </div>
                <div class="admin-modal-footer">
                    <button type="button" class="admin-btn admin-btn-secondary" data-close-modal>Cancel</button>
                    <button type="submit" class="admin-btn admin-btn-primary" id="saveSettingsBtn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

</header>