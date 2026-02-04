<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('code') - Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f8f9fa;
        }

        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fff5f0 0%, #ffe5cc 100%);
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            color: #FF6600;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .glitch {
            animation: glitch 1s linear infinite;
        }

        @keyframes glitch {
            2%, 64% { transform: translate(2px, 0) skew(0deg); }
            4%, 60% { transform: translate(-2px, 0) skew(0deg); }
            62% { transform: translate(0,0) skew(5deg); }
        }

        h2 {
            font-size: 1.5rem;
            color: #333;
        }

        p.lead {
            color: #555;
        }

        .btn-orange {
            background-color: #FF6600;
            color: #fff;
            border: none;
            border-radius: 0;
            width: 150px;
            height: 50px;
        }

        .btn-orange:hover {
            background-color: #e65c00;
            color: #fff;
        }

        .btn-report {
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 0;
            width: 150px;
            height: 50px;
        }

        .btn-report:hover {
            background-color: #555;
            color: #fff;
        }

    </style>
</head>
<body>

<div class="error-page">
    <div class="container text-center">
        <h1 class="error-code glitch mb-4">@yield('code')</h1>
        <h2 class="mb-3">@yield('message_title')</h2>
        <p class="lead mb-5">@yield('message_text')</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="/" class="btn btn-orange btn-lg">Go Home</a>
            <a href="mailto:jeanluckawel45@gmail.com?subject=Report Issue&body=Hello%2C%20I%20found%20an%20issue%20on%20your%20website."
               class="btn btn-report btn-lg">Report Issue</a>
        </div>
    </div>
</div>

</body>
</html>
