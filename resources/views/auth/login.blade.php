<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>KIT SERVICES SARL</title>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>


    <meta name="color-scheme" content="light dark"/>
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)"/>
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)"/>
    <meta name="supported-color-schemes" content="light dark"/>


    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96"/>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}"/>
    <link rel="manifest" href="{{ asset('site.webmanifest') }}"/>


    <title>@yield('title', 'Kit Services SARL')</title>
    <meta name="author" content="Jean Luc Kawel"/>
    <meta name="description" content="@yield('description', 'Connect to Kit Services to manage employees, clients, invoices, and more.')"/>
    <meta name="keywords" content="Kit Services, employee management, client management, invoices, HR, business management"/>


    <meta property="og:type" content="website"/>
    <meta property="og:title" content="@yield('og:title', 'Kit Services')"/>
    <meta property="og:description" content="@yield('og:description', 'Connect to Kit Services to manage employees, clients, invoices, and more.')"/>
    <meta property="og:image" content="@yield('og:image', asset('logo/img.png'))"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:site_name" content="Kit Services"/>


    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="@yield('twitter:title', 'Kit Services | Login')"/>
    <meta name="twitter:description" content="@yield('twitter:description', 'Connect to Kit Services to manage employees, clients, invoices, and more.')"/>
    <meta name="twitter:image" content="@yield('twitter:image', asset('logo/img.png'))"/>
    <meta name="twitter:site" content="@KitServices"/>


    <link rel="icon" href="{{ asset('logo/img.png') }}" type="image/png"/>



    <link rel="preload" href="{{ asset('css/adminlte.css') }}" as="style"/>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
        crossorigin="anonymous"
        media="print"
        onload="this.media='all'"
    />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous"
    />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous"
    />

    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}"/>
</head>

<body class="login-page bg-body-secondary">

<div class="login-box">
    <div class="card">
        <div class="card-body login-card-body">


            <div class="login-logo d-flex justify-content-center align-items-center mb-3">
                <img src="{{ asset('logo/img.png') }}" alt="Kit Services Logo" class="me-2" style="height:80px; width:auto;">
                <span class="fs-4 fw-bold">Kit Services</span>
            </div>

            <p class="login-box-msg text-center">Sign in to start your session</p>


            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif


            <form method="POST" action="{{ route('login') }}">
                @csrf


                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                </div>
                @error('email')
                <span class="text-danger small">{{ $message }}</span>
                @enderror


                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autocomplete="current-password">
                    <div class="input-group-text">
                        <span class="bi bi-lock-fill"></span>
                        <i class="bi bi-eye-slash ms-2" id="togglePassword" style="cursor:pointer;"></i>
                    </div>
                </div>
                @error('password')
                <span class="text-danger small">{{ $message }}</span>
                @enderror


                <div class="row mb-3">
                    <div class="col-8 d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember"> Remember Me </label>
                        </div>
                    </div>
                    <div class="col-4 d-grid">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>

            <p class="mb-1 text-center">
                <a href="mailto:jeanluckawel45@gmail.com?subject=Support%20Request&body=Hello,%0A%0AIssue:%20[describe%20your%20issue]%0AName:%20[your%20name]%0A%0AThanks">
                    Contact Support
                </a>
            </p>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>


<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>
