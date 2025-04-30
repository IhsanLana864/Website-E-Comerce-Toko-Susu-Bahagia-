<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('admin/css/auth.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="auth-bg" style="background-image: url('{{ asset('assets/images/Background1.png') }}'); background-size: cover;">
        <div class="auth-overlay d-flex justify-content-center align-items-center vh-100">
            @yield('content')
        </div>
    </div>
</body>
</html>
