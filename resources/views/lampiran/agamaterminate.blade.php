@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Agama</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Master Data</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Central</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('/lampiran/agama') }}">Agama</a>
                        </li>
                        <li class="breadcrumb-item active">Terminate</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4">
                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Terminate Agama</h5>
                    </div>

                    <div class="user-thumb text-center">
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
                        <form action="{{ url('/lampiran/agama_terminate_save') }}" method="post">
                            @csrf

                            @foreach ($post as $res)
                                <input type="hidden" id="txtId" name="id" value="{{ $res->id }}">

                                <div class="mb-3">
                                    <label class="form-label" for="txtNama">Nama</label>

                                    <input type="text" class="form-control id="txtNama" name="nama" placeholder="Nama"
                                        value="{{ $res->nama }}" disabled="">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="txtCatatan">Catatan</label>

                                    <textarea class="form-control @error('catatan') is-invalid @enderror" id="txtCatatan" rows="3" name="catatan"
                                        required autofocus>{{ old('catatan', $res->status_note) }}</textarea>

                                    @error('catatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-2 mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
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
