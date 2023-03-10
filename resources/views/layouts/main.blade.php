<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="{{ request()->session()->get('theme') }}"
    data-layout-mode="{{ request()->session()->get('theme') }}" data-sidebar="dark"
    data-sidebar-size="{{ request()->session()->get('sidebar') }}" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>{{ session('populus_software_nama') }} | {{ session('populus_software_tagline') }}</title>

    <link rel="shortcut icon" href="{{ url('/storage/icon.png') }}">

    @include('partials.main_header')
</head>

<body>
    <div id="layout-wrapper">
        @include('partials.main_topmenu')

        @include('partials.main_sidemenu')

        <div class="vertical-overlay"></div>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('container')

                    @include('partials.main_copyright')
                </div>
            </div>
        </div>
    </div>

    <script>
        function set_theme() {
            axios.get("{{ url('/dashboard_set_theme') }}")
                .then(function(response) {
                    console.log(response);
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        function set_sidebar() {
            axios.get("{{ url('/dashboard_set_sidebar') }}")
                .then(function(response) {
                    console.log(response);
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        function set_lockscreen() {
            $('#lblLockscreen').attr('hidden', 'hidden');
            $('#txtPasswordLockscreen').val('');

            axios.get("{{ url('/lockscreen') }}")
                .then(function(response) {
                    console.log(response);
                })
                .catch(function(error) {
                    console.log(error);
                });

            $('#txtPasswordLockscreen').focus();
        }

        function set_unlockscreen() {
            let password = document.querySelector("#txtPasswordLockscreen");

            axios.post("{{ url('/unlockscreen') }}", {
                    _token: "{{ csrf_token() }}",
                    password: password.value
                })
                .then(function(response) {
                    let data = response.data.success;

                    if (data == 'Y') {
                        $('#modalLockScreen').modal('hide');
                    }
                })
                .catch(function(error) {
                    $('#lblLockscreen').removeAttr('hidden');
                });
        }
    </script>
</body>

</html>
