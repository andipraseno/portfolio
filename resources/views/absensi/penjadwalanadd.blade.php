@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Setup Penjadwalan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Absensi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('/absensi/penjadwalan') }}">Penjadwalan</a>
                        </li>
                        <li class="breadcrumb-item active">Setup</li>
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
                        <h5 class="text-primary">Input Calendar</h5>
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
                        <form action="{{ url('/absensi/penjadwalan_add_save') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="cboTahun">Tahun</label>

                                <select class="form-select form-select-sm" id="cboTahun" name="tahun">
                                    @php
                                        $tahun_start = date('Y') - 5;
                                        $tahun_end = date('Y') + 100;
                                    @endphp

                                    @for ($a = $tahun_start; $a <= $tahun_end; $a++)
                                        <option value="{{ $a }}" {{ $a == date('Y') ? 'selected' : '' }}>
                                            {{ $a }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="dtpDariJam">Jam Kerja</label>

                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" id="dtpDariJam" name="darijam"
                                            value="08:00">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="time" class="form-control" id="dtpSampaiJam" name="sampaijam"
                                            value="17:00">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2 mt-4">
                                <button class="btn btn-primary w-100" type="submit">Simpan</button>
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
