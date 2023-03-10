@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Change Password</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a>
                        </li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Change Password</h5>
                        <p class="text-muted">Enter your current password to confirm!</p>
                    </div>

                    <div class="user-thumb text-center">
                        <img src="{{ url('storage/users/' .request()->session()->get('user_id') .'.jpg') }}"
                            class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                        <h5 class="font-size-15 mt-3">{{ request()->session()->get('user_nama') }}</h5>

                        @if (session()->has('loginSuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="success">
                                {{ session('loginSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session()->has('loginError'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('loginError') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>

                    <div class="p-2 mt-4">
                        <form action="{{ url('/changepassword_save') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="txtPassword1">Current Password</label>

                                <input type="password" class="form-control" id="txtPassword1" name="txtPassword1"
                                    placeholder="Enter Current Password" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="txtPassword2">New Password</label>

                                <input type="password" class="form-control" id="txtPassword2" name="txtPassword2"
                                    placeholder="Enter New Password" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="txtPassword3">Confirmation Password</label>

                                <input type="password" class="form-control" id="txtPassword3" name="txtPassword3"
                                    placeholder="Enter Confirmation Password" required>
                            </div>

                            <div class="mb-2 mt-4">
                                <button class="btn btn-primary w-100" type="submit">Ubah Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.main_footer')

    <script></script>
@endsection
