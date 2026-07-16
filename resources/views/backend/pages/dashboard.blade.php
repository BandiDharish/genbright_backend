@extends('backend.layout.app')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard Overview')

@section(
    'page-description',
    'Manage your website content and enquiries.'
)

@section('content')

<div class="welcome-card">

    <div class="welcome-content">

        <span class="welcome-label">
            Admin Control Panel
        </span>

        <h2>
            Welcome back,
            {{ auth()->user()->name }}
        </h2>

        <p>
            Manage website sections, student enquiries,
            admission requests and important information
            from one secure dashboard.
        </p>

    </div>

</div>

<div class="dashboard-cards">

    <div class="dashboard-card">
        <h3>Total Enquiries</h3>

        <strong>
            {{ $statistics['enquiries'] ?? 0 }}
        </strong>

        <p>Submitted contact enquiries</p>
    </div>

    <div class="dashboard-card">
        <h3>Admissions</h3>

        <strong>
            {{ $statistics['admissions'] ?? 0 }}
        </strong>

        <p>New admission requests</p>
    </div>

    <div class="dashboard-card">
        <h3>Media Items</h3>

        <strong>
            {{ $statistics['media'] ?? 0 }}
        </strong>

        <p>Images and videos published</p>
    </div>

    <div class="dashboard-card">
        <h3>Administrators</h3>

        <strong>
            {{ $statistics['admins'] ?? 1 }}
        </strong>

        <p>Active admin accounts</p>
    </div>

</div>

<div class="admin-dashboard-grid">

    <div class="admin-card">

        <div class="admin-card-header">
            <h3>Recent Activity</h3>

            <p>
                Latest updates from your admin panel
            </p>
        </div>

        <div class="admin-activity-list">

            <div class="admin-activity-item">

                <div class="admin-activity-icon">
                    ✓
                </div>

                <div class="admin-activity-content">
                    <strong>Dashboard configured</strong>
                    <span>Admin dashboard is ready</span>
                </div>

                <span class="admin-activity-time">
                    Today
                </span>

            </div>

            <div class="admin-activity-item">

                <div class="admin-activity-icon">
                    ✉
                </div>

                <div class="admin-activity-content">
                    <strong>Enquiry management</strong>
                    <span>View submitted contact forms</span>
                </div>

                <span class="admin-activity-time">
                    Pending
                </span>

            </div>

            <div class="admin-activity-item">

                <div class="admin-activity-icon">
                    ▣
                </div>

                <div class="admin-activity-content">
                    <strong>Media management</strong>
                    <span>Add website images and videos</span>
                </div>

                <span class="admin-activity-time">
                    Pending
                </span>

            </div>

        </div>

    </div>

    <div class="admin-card">

        <div class="admin-card-header">
            <h3>Quick Actions</h3>

            <p>Frequently used actions</p>
        </div>

        <div class="admin-quick-links">

            <a href="javascript:void(0)" class="admin-quick-link">

                <span class="admin-quick-link-content">
                    <span class="admin-quick-link-icon">＋</span>
                    Add Media
                </span>

                <span class="admin-quick-arrow">→</span>

            </a>

            <a href="javascript:void(0)" class="admin-quick-link">

                <span class="admin-quick-link-content">
                    <span class="admin-quick-link-icon">✉</span>
                    View Enquiries
                </span>

                <span class="admin-quick-arrow">→</span>

            </a>

            <a href="javascript:void(0)" class="admin-quick-link">

                <span class="admin-quick-link-content">
                    <span class="admin-quick-link-icon">▦</span>
                    Manage Admissions
                </span>

                <span class="admin-quick-arrow">→</span>

            </a>

            <a href="javascript:void(0)" class="admin-quick-link">

                <span class="admin-quick-link-content">
                    <span class="admin-quick-link-icon">⚙</span>
                    Website Settings
                </span>

                <span class="admin-quick-arrow">→</span>

            </a>

        </div>

    </div>

</div>

@endsection