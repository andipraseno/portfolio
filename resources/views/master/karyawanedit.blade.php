@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Karyawan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Master Data</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Central</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('/master/karyawan') }}">Karyawan</a>
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
                        <h5 class="text-primary">Edit Karyawan</h5>
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
                        <form action="{{ url('/master/karyawan_edit_save') }}" method="post">
                            @csrf

                            @foreach ($post as $res)
                                <input type="hidden" id="txtId" name="id" value="{{ $res->id }}">

                                <div class="mb-3">
                                    <label class="form-label" for="txtNama">Nama</label>

                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="txtNama" name="nama" placeholder="Nama"
                                        value="{{ old('nama', $res->nama) }}" required autofocus autocomplete="off">

                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="txtKode">Kode</label>

                                    <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                        id="txtKode" name="kode" placeholder="Kode"
                                        value="{{ old('kode', $res->kode) }}" required autocomplete="off">

                                    @error('kode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="txtPIN">PIN</label>

                                    <input type="password" class="form-control @error('pin') is-invalid @enderror"
                                        id="txtPIN" name="pin" placeholder="PIN" value="{{ old('pin', $res->pin) }}"
                                        required autocomplete="off">

                                    @error('pin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="cboDepartment">Department</label>

                                    <select class="js-example-basic-single" id="cboDepartment" name="department">
                                        @foreach ($department as $res_department)
                                            <option value="{{ $res_department->id }}"
                                                {{ old('department', $res->department_id) == $res_department->id ? 'selected' : '' }}>
                                                {{ $res_department->nama }}</option>
                                        @endforeach
                                    </select>

                                    @error('department')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="cboJabatan">Jabatan</label>

                                    <select class="js-example-basic-single" id="cboJabatan" name="jabatan">
                                        @foreach ($jabatan as $res_jabatan)
                                            <option value="{{ $res_jabatan->id }}"
                                                {{ old('jabatan', $res->jabatan_id) == $res_jabatan->id ? 'selected' : '' }}
                                                {{ $res_jabatan->combo_select }}>
                                                {{ $res_jabatan->nama }}</option>
                                        @endforeach
                                    </select>

                                    @error('jabatan')
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