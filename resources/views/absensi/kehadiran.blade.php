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
                        <li class="breadcrumb-item active">Kehadiran</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Daftar Kehadiran</h5>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9"></div>

                        <div class="col-md-3">
                            <div class="mb-2 d-flex">
                                <div class="d-block flex-shrink-0 me-3">
                                    Periode :
                                </div>

                                <select class="form-select form-select-sm" id="cboPeriode" name="periode">
                                    @php
                                        $nama_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    @endphp

                                    @foreach ($periode as $res_periode)
                                        <option value="{{ $res_periode->id }}"
                                            {{ $selected_periode == $res_periode->id ? 'selected' : '' }}>
                                            {{ $nama_bulan[$res_periode->bulan - 1] . ' ' . $res_periode->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <table id="dgvList" class="table table-bordered dt-responsive nowrap table-hover align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Karyawan Id</th>
                                <th>Jadwal Id</th>
                                <th width="20%" class="text-center">Nama</th>
                                <th width="15%" class="text-center">Department</th>
                                <th width="25%" class="text-center">Tanggal</th>
                                <th width="15%" class="text-center">Jadwal</th>
                                <th width="15%" class="text-center">Absen</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('partials.main_footer')

    <script>
        $(document).ready(function() {
            $('#myCollapsible').on('shown.bs.collapse', function() {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            var table = $('#dgvList').DataTable({
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('/absensi/kehadiran_list') }}",
                    "type": "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.periode_id = $('#cboPeriode').val();
                    }
                },
                order: [
                    [0, 'asc'],
                    [1, 'asc'],
                ],
                columns: [{
                        data: 'id',
                    },
                    {
                        data: 'jadwal_id'
                    },
                    {
                        data: 'nama',
                    },
                    {
                        data: 'department_nama',
                    },
                    {
                        data: 'tanggal',
                    },
                    {
                        data: 'jam',
                    },
                    {
                        data: 'tipe_nama',
                    },
                    {
                        data: 'id',
                    },
                ],
                columnDefs: [{
                        targets: [0, 1],
                        visible: false,
                    },
                    {
                        targets: [4, 5, 6],
                        className: "text-center",
                    },
                    {
                        targets: 6,
                        "render": function(data, type, row) {
                            let absen = '';
                            if (row['holiday'] == 1) {
                                absen = 'Libur';
                            } else {
                                absen = row['tipe_id'] == 1 ? row['absen'] : row['tipe_nama'];
                            }

                            return absen;
                        },
                    },
                    {
                        targets: 7,
                        orderable: false,
                        className: "text-center",
                        width: "100px",
                        render: function(data, type, row, meta) {
                            let hasil = '';

                            if (row['holiday'] == 0) {
                                hasil = `<a href="{{ url('/absensi/kehadiran_edit') }}/` +
                                    row['id'] +
                                    `/` + row['jadwal_id'] + `" class="btn btn-sm btn-primary">
                                        <i class="ri-send-plane-fill"></i>
                                    </a>`;
                            } else {
                                hasil = '';
                            }

                            return hasil;
                        }
                    },
                ]
            });

            $('#cboPeriode').on('change', function() {
                table.ajax.reload(null, false);
            });
        });
    </script>
@endsection
