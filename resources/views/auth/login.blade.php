<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Kit Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="icon" href="{{ asset('logo/img.png') }}" type="image/png">


    <meta property="og:type" content="website">
    <meta property="og:title" content="Kit Services">
    <meta property="og:description" content="Connect to Kit Services to manage employees, clients, invoices and more.">
    <meta property="og:image" content="{{ asset('logo/img.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Kit Services">


    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Kit Services | Login">
    <meta name="twitter:description" content="Connect to Kit Services to manage employees, clients, invoices and more.">
    <meta name="twitter:image" content="{{ asset('logo/img.png') }}">
    <meta name="twitter:site" content="@KitServices">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
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
