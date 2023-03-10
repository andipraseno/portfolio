@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tipe Absen</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Master Data</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Central</a>
                        </li>
                        <li class="breadcrumb-item active">Tipe Absen</li>
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
                        <h5 class="card-title mb-0 flex-grow-1">Daftar Tipe Absen</h5>
                        <div>
                            <a href="{{ url('/lampiran/tipeabsen_add') }}" id="addRow" class="btn btn-primary">
                                <i class="ri-add-fill"></i> Add
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="dgvList" class="table table-bordered dt-responsive nowrap table-hover align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th width="25%" class="text-center">Id</th>
                                <th width="65%">Nama</th>
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
                    "url": "{{ url('/lampiran/tipeabsen_list') }}",
                    "type": "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [{
                        data: 'id',
                    },
                    {
                        data: 'nama',
                    },
                    {
                        data: 'nama',
                    },
                ],
                columnDefs: [{
                        targets: 0,
                        className: "text-center",
                    },
                    {
                        targets: 2,
                        orderable: false,
                        className: "text-center",
                        width: "100px",
                        render: function(data, type, row, meta) {
                            return `<div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="{{ url('/lampiran/tipeabsen_edit') }}/` + row['id'] + `"
                                                    class="dropdown-item edit-item-btn">
                                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/lampiran/tipeabsen_terminate') }}/` + row['id'] + `"
                                                    class="dropdown-item remove-item-btn">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Terminate
                                                </a>
                                            </li>
                                        </ul>
                                    </div>`;
                        }
                    },
                ]
            });
        });
    </script>
@endsection
