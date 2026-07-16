<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Admin Dashboard')
    </title>


    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">


    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    {{-- Plugin CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    {{-- Admin CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/backend/css/dashboard.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/backend/css/layout.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/backend/css/crud.css') }}">


    {{-- Page-specific CSS --}}
    @stack('styles')

</head>

<body>

    <div class="admin-wrapper">

        {{-- Sidebar --}}
        @include('backend.partials.sidebar')


        <div class="admin-main">

            {{-- Header --}}
            @include('backend.partials.header')


            {{-- Main Content --}}
            <main class="admin-content">

                @yield('content')

            </main>


            {{-- Footer --}}
            @include('backend.partials.footer')

        </div>

    </div>


    {{-- jQuery is required by Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    {{-- Plugin JavaScript --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- Admin JavaScript --}}
    <script src="{{ asset('assets/backend/js/admin.js') }}"></script>

    <script src="{{ asset('assets/backend/js/layout.js') }}"></script>


    {{-- Toastr Configuration --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (typeof toastr === 'undefined') {
                return;
            }

            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                onclick: null,
                showDuration: 300,
                hideDuration: 600,
                timeOut: 4000,
                extendedTimeOut: 1000,
                showEasing: 'swing',
                hideEasing: 'linear',
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut'
            };


            @if (session('success'))
                toastr.success(
                    @json(session('success')),
                    'Success'
                );
            @endif


            @if (session('error'))
                toastr.error(
                    @json(session('error')),
                    'Error'
                );
            @endif


            @if (session('warning'))
                toastr.warning(
                    @json(session('warning')),
                    'Warning'
                );
            @endif


            @if (session('info'))
                toastr.info(
                    @json(session('info')),
                    'Information'
                );
            @endif

        });
    </script>


    {{-- Rare page-specific JavaScript --}}
    @stack('scripts')

</body>

</html>
