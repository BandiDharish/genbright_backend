@extends('backend.layouts.app')

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





@endsection