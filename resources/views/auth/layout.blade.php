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
    <div class="auth-bg"
        style="background-image: url('{{ asset('assets/images/Background1.png') }}'); background-size: cover;">
        <div class="auth-overlay d-flex align-items-center vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
