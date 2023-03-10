@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">User Profile</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Dashboards</a>
                        </li>

                        <li class="breadcrumb-item active">User Profile</li>
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
                        <h5 class="text-primary">User Profile</h5>
                        <p class="text-muted">Updating this data will effect to your user and login information!
                        </p>
                    </div>

                    <div class="user-thumb text-center">
                        <img src="{{ url('storage/users/' .request()->session()->get('user_id') .'.jpg') }}"
                            class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                        <h5 class="font-size-15 mt-3">{{ request()->session()->get('user_nama') }}</h5>

                        @if (session()->has('formSuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="success">
                                {{ session('formSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session()->has('formError'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('formError') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>

                    <div class="p-2 mt-4">
                        <form action="{{ url('/userprofile_save') }}" method="post">
                            @csrf

                            @foreach ($post as $res)
                                <div class="mb-3">
                                    <label class="form-label" for="txtNama">Nama</label>

                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="txtNama" name="nama" placeholder="Nama"
                                        value="{{ old('nama', $res->nama) }}" required autofocus>

                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="txtLevel">Level</label>

                                    <input type="text" class="form-control" id="txtLevel" name="level"
                                        placeholder="Level" value="{{ $res->level_nama }}" readonly>
                                </div>

                                <div class="mb-2 mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Ubah Pengguna</button>
                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.main_footer')

    <script></script>
@endsection