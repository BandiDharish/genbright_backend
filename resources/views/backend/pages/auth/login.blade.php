<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>Admin Login | GenBright World School</title>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>
        :root {
            --login-dark: #16212f;
            --login-green: #174c36;
            --login-green-dark: #103b2a;
            --login-sage: #789b69;
            --login-sage-light: #eaf0e6;
            --login-background: #f5f7f3;
            --login-white: #ffffff;
            --login-warm-white: #fcfcf9;
            --login-text: #29352f;
            --login-muted: #6d786f;
            --login-border: #e4e9e1;
            --login-danger: #c95d54;
            --login-success: #43825f;
            --login-gold: #dda00a;
            --login-shadow: 0 30px 80px rgba(22, 33, 47, 0.15);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: "DM Sans", sans-serif;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(120, 155, 105, 0.2),
                    transparent 32%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(23, 76, 54, 0.11),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #fbfcf9,
                    #eef3eb
                );
            color: var(--login-text);
        }

        button,
        input {
            font: inherit;
        }

        .admin-login-page {
            min-height: 100vh;
            padding: 25px;
            display: grid;
            place-items: center;
        }

        .admin-login-card {
            width: 100%;
            max-width: 1040px;
            min-height: 620px;
            overflow: hidden;
            border: 1px solid var(--login-border);
            border-radius: 26px;
            background: var(--login-white);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            box-shadow: var(--login-shadow);
        }

        /* Left section */

        .login-visual {
            padding: 48px;
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(
                    135deg,
                    rgba(22, 33, 47, 0.97),
                    rgba(23, 76, 54, 0.95)
                );
            color: var(--login-white);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .login-visual::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            top: -120px;
            right: -110px;
            border-radius: 50%;
            background: rgba(120, 155, 105, 0.22);
        }

        .login-visual::after {
            content: "";
            position: absolute;
            width: 170px;
            height: 170px;
            left: -75px;
            bottom: -75px;
            border: 38px solid rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        .login-brand {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .login-brand-mark {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            border-radius: 15px;
            background: var(--login-green);
            display: grid;
            place-items: center;
            font-family: "Playfair Display", serif;
            font-size: 25px;
            font-weight: 700;
            box-shadow: 0 10px 24px rgba(8, 39, 27, 0.3);
        }

        .login-brand h2 {
            font-family: "Playfair Display", serif;
            font-size: 19px;
            font-weight: 600;
        }

        .login-brand p {
            margin-top: 3px;
            color: rgba(255, 255, 255, 0.52);
            font-size: 10px;
            letter-spacing: 0.6px;
        }

        .login-message {
            position: relative;
            z-index: 2;
            max-width: 460px;
        }

        .login-message-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 17px;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, 0.13);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.07);
            color: #deead9;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .login-message h1 {
            margin-bottom: 18px;
            font-family: "Playfair Display", serif;
            font-size: 43px;
            font-weight: 600;
            line-height: 1.14;
        }

        .login-message h1 span {
            color: #b9d1ad;
            font-style: italic;
        }

        .login-message p {
            max-width: 430px;
            color: rgba(255, 255, 255, 0.66);
            font-size: 14px;
            line-height: 1.8;
        }

        .login-features {
            position: relative;
            z-index: 2;
            margin-top: 26px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
        }

        .login-feature {
            min-height: 51px;
            padding: 0 13px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.055);
            color: rgba(255, 255, 255, 0.72);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
        }

        .login-feature i {
            color: #bdd4b2;
        }

        .login-copyright {
            position: relative;
            z-index: 2;
            color: rgba(255, 255, 255, 0.42);
            font-size: 10px;
        }

        /* Right section */

        .login-form-section {
            padding: 66px 58px;
            background: var(--login-warm-white);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-heading {
            margin-bottom: 31px;
        }

        .login-heading-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--login-green);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .login-heading-label::before {
            content: "";
            width: 21px;
            height: 1px;
            background: var(--login-sage);
        }

        .login-heading h2 {
            margin: 11px 0 11px;
            color: var(--login-dark);
            font-family: "Playfair Display", serif;
            font-size: 34px;
            font-weight: 600;
        }

        .login-heading p {
            max-width: 410px;
            color: var(--login-muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .login-alert {
            margin-bottom: 20px;
            padding: 13px 15px;
            border-radius: 11px;
            display: flex;
            align-items: flex-start;
            gap: 9px;
            font-size: 12px;
            line-height: 1.55;
        }

        .login-alert-success {
            border: 1px solid #cce1d2;
            background: #edf7f0;
            color: var(--login-success);
        }

        .login-alert-danger {
            border: 1px solid #efcbc7;
            background: #fff2f1;
            color: var(--login-danger);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--login-dark);
            font-size: 12px;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            color: #91a08f;
            font-size: 14px;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            height: 53px;
            padding: 0 45px 0 44px;
            border: 1px solid var(--login-border);
            border-radius: 12px;
            background: #ffffff;
            color: var(--login-dark);
            font-size: 13px;
            outline: none;
            transition: 0.22s ease;
        }

        .form-control::placeholder {
            color: #a5ada6;
        }

        .form-control:focus {
            border-color: var(--login-sage);
            box-shadow: 0 0 0 4px rgba(120, 155, 105, 0.13);
        }

        .form-control.is-invalid {
            border-color: var(--login-danger);
        }

        .password-toggle {
            width: 40px;
            height: 40px;
            position: absolute;
            top: 50%;
            right: 6px;
            transform: translateY(-50%);
            border: none;
            border-radius: 9px;
            background: transparent;
            color: #8d998e;
            display: grid;
            place-items: center;
            cursor: pointer;
        }

        .password-toggle:hover {
            background: var(--login-sage-light);
            color: var(--login-green);
        }

        .form-error {
            display: block;
            margin-top: 7px;
            color: var(--login-danger);
            font-size: 11px;
        }

        .login-options {
            margin-bottom: 23px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .remember-label {
            color: var(--login-muted);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            cursor: pointer;
        }

        .remember-label input {
            width: 15px;
            height: 15px;
            accent-color: var(--login-green);
        }

        .secure-label {
            color: var(--login-muted);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
        }

        .secure-label i {
            color: var(--login-sage);
        }

        .login-button {
            width: 100%;
            height: 54px;
            border: none;
            border-radius: 12px;
            background: var(--login-green);
            color: var(--login-white);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 12px 25px rgba(23, 76, 54, 0.21);
            transition: 0.25s ease;
        }

        .login-button:hover {
            background: var(--login-green-dark);
            transform: translateY(-1px);
            box-shadow: 0 15px 30px rgba(23, 76, 54, 0.25);
        }

        .login-help {
            margin-top: 21px;
            color: var(--login-muted);
            text-align: center;
            font-size: 10px;
            line-height: 1.6;
        }

        .login-help strong {
            color: var(--login-green);
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .admin-login-card {
                max-width: 560px;
                grid-template-columns: 1fr;
            }

            .login-visual {
                min-height: 320px;
                padding: 35px;
            }

            .login-message h1 {
                font-size: 31px;
            }

            .login-message p {
                font-size: 13px;
            }

            .login-features,
            .login-copyright {
                display: none;
            }

            .login-form-section {
                padding: 47px 38px;
            }
        }

        @media (max-width: 520px) {
            .admin-login-page {
                padding: 12px;
            }

            .admin-login-card {
                min-height: auto;
                border-radius: 18px;
            }

            .login-visual {
                display: none;
            }

            .login-form-section {
                padding: 39px 23px;
            }

            .login-heading h2 {
                font-size: 29px;
            }

            .login-options {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<section class="admin-login-page">

    <div class="admin-login-card">

        <div class="login-visual">

            <div class="login-brand">

                <div class="login-brand-mark">
                    G
                </div>

                <div>
                    <h2>GenBright</h2>
                    <p>World School Admin Portal</p>
                </div>

            </div>

            <div class="login-message">

                <span class="login-message-label">
                    <i class="fa-solid fa-leaf"></i>
                    Secure Administration
                </span>

                <h1>
                    Manage every
                    <span>moment</span>
                    with clarity.
                </h1>

                <p>
                    Access website content, admission requests,
                    media, campus information and customer
                    enquiries from one secure dashboard.
                </p>

                <div class="login-features">

                    <div class="login-feature">
                        <i class="fa-solid fa-shield-halved"></i>
                        Protected admin access
                    </div>

                    <div class="login-feature">
                        <i class="fa-solid fa-chart-line"></i>
                        Simple content management
                    </div>

                </div>

            </div>

            <p class="login-copyright">
                © {{ date('Y') }} GenBright World School.
                All rights reserved.
            </p>

        </div>

        <div class="login-form-section">

            <div class="login-heading">

                <span class="login-heading-label">
                    Admin Portal
                </span>

                <h2>Welcome back</h2>

                <p>
                    Enter your administrator email and password
                    to continue to the dashboard.
                </p>

            </div>

            @if(session('success'))
                <div class="login-alert login-alert-success">
                    <i class="fa-solid fa-circle-check"></i>

                    <span>
                        {{ session('success') }}
                    </span>
                </div>
            @endif

            @if(session('error'))
                <div class="login-alert login-alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>

                    <span>
                        {{ session('error') }}
                    </span>
                </div>
            @endif

            <form
                action="{{ route('admin.login.submit') }}"
                method="POST"
            >
                @csrf

                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <div class="input-wrapper">

                        <i class="fa-regular fa-envelope input-icon"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control
                            @error('email') is-invalid @enderror"
                            placeholder="admin@example.com"
                            autocomplete="email"
                            autofocus
                            required
                        >

                    </div>

                    @error('email')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-wrapper">

                        <i class="fa-solid fa-lock input-icon"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control
                            @error('password') is-invalid @enderror"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="passwordToggle"
                            aria-label="Show password"
                        >
                            <i
                                class="fa-regular fa-eye"
                                id="passwordToggleIcon"
                            ></i>
                        </button>

                    </div>

                    @error('password')
                        <span class="form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                <div class="login-options">

                    <label class="remember-label">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            {{ old('remember') ? 'checked' : '' }}
                        >

                        Remember me

                    </label>

                    <span class="secure-label">
                        <i class="fa-solid fa-lock"></i>
                        Secure login
                    </span>

                </div>

                <button
                    type="submit"
                    class="login-button"
                >
                    <span>Login to Dashboard</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>

            <p class="login-help">
                This page is only for authorized
                <strong>administrators</strong>.
            </p>

        </div>

    </div>

</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput =
            document.getElementById("password");

        const passwordToggle =
            document.getElementById("passwordToggle");

        const passwordToggleIcon =
            document.getElementById("passwordToggleIcon");

        passwordToggle?.addEventListener("click", function () {
            const passwordIsHidden =
                passwordInput.type === "password";

            passwordInput.type =
                passwordIsHidden ? "text" : "password";

            passwordToggleIcon.classList.toggle(
                "fa-eye",
                !passwordIsHidden
            );

            passwordToggleIcon.classList.toggle(
                "fa-eye-slash",
                passwordIsHidden
            );

            passwordToggle.setAttribute(
                "aria-label",
                passwordIsHidden
                    ? "Hide password"
                    : "Show password"
            );
        });
    });
</script>

</body>
</html>