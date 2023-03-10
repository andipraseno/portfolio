@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Kehadiran</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Absensi</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('/absensi/kehadiran') }}">Kehadiran</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <h5 class="text-primary">Edit Kehadiran</h5>
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
                        <form action="{{ url('/absensi/kehadiran_edit_save') }}" method="post">
                            @csrf

                            @foreach ($post as $res)
                                <input type="hidden" id="txtKaryawanId" name="karyawan_id" value="{{ $res->id }}">
                                <input type="hidden" id="txtJadwalId" name="jadwal_id" value="{{ $res->jadwal_id }}">
                                <input type="hidden" id="txtDariJam" name="dari_jam" value="{{ $res->dari_jam }}">
                                <input type="hidden" id="txtSampaiJam" name="sampai_jam" value="{{ $res->sampai_jam }}">

                                <div class="mb-3">
                                    <label class="form-label" for="txtNama">Karyawan</label>

                                    <input type="text" class="form-control" id="txtNama" name="nama"
                                        placeholder="Nama" value="{{ old('nama', $res->nama) }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="txtTanggal">Tanggal</label>

                                    <input type="text" class="form-control" id="txtTanggal" name="tanggal"
                                        placeholder="tanggal" value="{{ old('tanggal', $res->tanggal) }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="cboTipe">Tipe</label>

                                    <select class="js-example-basic-single" id="cboTipe" name="tipe">
                                        @foreach ($tipe as $res_tipe)
                                            <option value="{{ $res_tipe->id }}"
                                                {{ old('tipe', $res->tipe_id) == $res_tipe->id ? 'selected' : '' }}>
                                                {{ $res_tipe->nama }}</option>
                                        @endforeach
                                    </select>

                                    @error('tipe')
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
