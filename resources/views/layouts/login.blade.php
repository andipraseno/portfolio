<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="{{ request()->session()->get('theme') }}"
    data-layout-mode="{{ request()->session()->get('theme') }}" data-sidebar="dark"
    data-sidebar-size="{{ request()->session()->get('sidebar') }}" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Welcome to {{ session('populus_software_nama') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ url('/storage/icon.png') }}">

    @include('partials.login_header')

    <style>
        .wallpaper {
            position: relative;
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wallpaper::before {
            content: "";
            background-image: url('{{ url('/storage/background.jpg') }}');
            background-size: cover;
            position: absolute;
            top: 0px;
            right: 0px;
            bottom: 0px;
            left: 0px;
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <div class="wallpaper">
        @yield('container')
    </div>
</body>

</html>
