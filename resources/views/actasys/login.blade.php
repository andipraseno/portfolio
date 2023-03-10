@extends('layouts.login')

@section('container')
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div>
                                <a href="{{ url('/') }}">
                                    <img src="{{ url('/storage/banner.png') }}" alt="" height="30px" width="250px"
                                        class="img-fluid">
                                </a>
                            </div>

                            <p class="mt-3 fs-15 fw-medium">Human Resource Management</p>

                            @if (session()->has('formError'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('formError') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                        </div>

                        <div class="p-2">
                            <form action="{{ url('/login') }}" method="post" autocomplete="off">
                                @csrf

                                <div class="mb-3">
                                    <label for="txtNama" class="form-label">User Name</label>

                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="txtNama" name="nama" placeholder="Enter Name" value="{{ old('nama') }}"
                                        autofocus required>

                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="txtPassword">Password</label>

                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" class="form-control pe-5 password-input"
                                            placeholder="Enter password" id="txtPassword" name="password" required>

                                        <button
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-addon"><i
                                                class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-success w-100" type="submit">Sign In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer start-0" style="background-color: transparent;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0" style="color: white; font-size: 12pt;">
                            <a href="http://www.actasys.com">{{ session('populus_software_copyright') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @include('partials.login_footer')

    <script></script>
@endsection
