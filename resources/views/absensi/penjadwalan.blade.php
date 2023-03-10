@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Penjadwalan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Absensi</a>
                        </li>
                        <li class="breadcrumb-item active">Penjadwalan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
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
                        </h5>

                        <div>
                            @if (count($periode) <= 0)
                                <a href="{{ url('/absensi/penjadwalan_add') }}" id="btnSetupPeriode"
                                    class="btn btn-primary btn-sm">
                                    <i class="ri-ball-pen-fill"></i> Setup Periode
                                </a>
                            @endif

                            @if (count($periode) > 0)
                                <button type="button" id="btnAgenda" class="btn btn-primary" onClick="show_agenda()">
                                    <i class="ri-add-fill"></i> Agenda
                                </button>
                            @endif
                        </div>
                    </div>

                    <table id="dgvList" class="table table-bordered dt-responsive nowrap align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th width="14%" class="text-center">Senin</th>
                                <th width="14%" class="text-center">Selasa</th>
                                <th width="14%" class="text-center">Rabu</th>
                                <th width="14%" class="text-center">Kamis</th>
                                <th width="14%" class="text-center">Jumat</th>
                                <th width="14%" class="text-center">Sabtu</th>
                                <th width="15%" class="text-center">Minggu</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="MyForm" action="{{ url('/absensi/penjadwalan_agenda_save') }}" method="post">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModal">Agenda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="dtpTglDari">Tanggal</label>

                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" class="form-control @error('tgl_dari') is-invalid @enderror"
                                        id="dtpTglDari" name="tgl_dari" placeholder="Tgl. Dari"
                                        value="{{ old('tgl_dari') }}" required autofocus>

                                    @error('tgl_dari')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="date" class="form-control @error('tgl_sampai') is-invalid @enderror"
                                        id="dtpTglSampai" name="tgl_sampai" placeholder="Tgl. Sampai"
                                        value="{{ old('tgl_sampai') }}" required autofocus>

                                    @error('tgl_sampai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="chkLibur" name="libur">
                            <label class="form-check-label" for="chkLibur">Libur</label>
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

                        <input type="hidden" class="form-control" id="txtTanggalFormat" name="tanggalformat">

                        <div class="mb-3">
                            <label class="form-label" for="txtCatatan">Catatan</label>

                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="txtCatatan" rows="3" name="catatan">{{ old('catatan') }}</textarea>

                            @error('catatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="myModal2" tabindex="-1" aria-labelledby="varyingcontentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="MyForm2" action="{{ url('/absensi/penjadwalan_dailyagenda_save') }}" method="post">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModal">Daily Agenda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="txtId2" name="id2">

                        <div class="mb-3">
                            <label class="form-label" for="dtpTanggal2">Tanggal</label>

                            <input type="text" class="form-control" id="dtpTanggal2" name="tanggal2"
                                placeholder="Tanggal" readonly>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="chkLibur2"
                                name="libur2">

                            <label class="form-check-label" for="chkLibur2">Libur</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="dtpDariJam">Jam Kerja</label>

                            <div class="row">
                                <div class="col-md-6">
                                    <input type="time" class="form-control" id="dtpDariJam2" name="darijam2"
                                        value="08:00">
                                </div>

                                <div class="col-md-6">
                                    <input type="time" class="form-control" id="dtpSampaiJam2" name="sampaijam2"
                                        value="17:00">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" id="txtTanggalFormat2" name="tanggalformat2">

                        <div class="mb-3">
                            <label class="form-label" for="txtCatatan2">Catatan</label>

                            <textarea class="form-control @error('catatan2') is-invalid @enderror" id="txtCatatan2" rows="3"
                                name="catatan2">{{ old('catatan2') }}</textarea>

                            @error('catatan2')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('partials.main_footer')

    <script>
        $(document).ready(function() {
            load_penjadwalan('{{ $selected_periode }}');

            $('#cboPeriode').on('change', function() {
                let periode_id = $('#cboPeriode :selected').val();

                load_penjadwalan(periode_id);
            });
        });

        function load_penjadwalan(periode_id) {
            const button = 'btn rounded-pill btn-light waves-effect btn-lg';
            const button_holiday = 'btn rounded-pill btn-danger waves-effect waves-light btn-lg';
            let button_class = button;
            let message_icon = '';

            axios.post("{{ url('/absensi/penjadwalan_list') }}", {
                    "periode_id": periode_id,
                })
                .then(function(response) {
                    let data = response.data.data;

                    let html = "";

                    for (var k in data) {
                        let has = data[k].hasil.split('---');

                        console.log(has);

                        if (data[k].baris == 1) {
                            let start = has[0].split('--');
                            let start_at = start[0];

                            let senin = '';
                            let selasa = '';
                            let rabu = '';
                            let kamis = '';
                            let jumat = '';
                            let sabtu = '';
                            let minggu = '';

                            if (start_at == 1) {
                                senin = has[0];
                                selasa = has[1];
                                rabu = has[2];
                                kamis = has[3];
                                jumat = has[4];
                                sabtu = has[5];
                                minggu = has[6];
                            } else if (start_at == 2) {
                                selasa = has[0];
                                rabu = has[1];
                                kamis = has[2];
                                jumat = has[3];
                                sabtu = has[4];
                                minggu = has[5];
                            } else if (start_at == 3) {
                                rabu = has[0];
                                kamis = has[1];
                                jumat = has[2];
                                sabtu = has[3];
                                minggu = has[4];
                            } else if (start_at == 4) {
                                kamis = has[0];
                                jumat = has[1];
                                sabtu = has[2];
                                minggu = has[3];
                            } else if (start_at == 5) {
                                jumat = has[0];
                                sabtu = has[1];
                                minggu = has[2];
                            } else if (start_at == 6) {
                                sabtu = has[0];
                                minggu = has[1];
                            } else if (start_at == 7) {
                                minggu = has[0];
                            }

                            const data_baru = [senin, selasa, rabu, kamis, jumat, sabtu, minggu];

                            let id = "";
                            let libur = "";
                            let tanggal = "";
                            let jam_dari = "";
                            let jam_sampai = "";
                            let tanggal_format = "";
                            let catatan = "";

                            html += "<tr class='text-center' style='height: 100px'>>";

                            for (let a = 0; a <= 6; a++) {
                                id = "";
                                tgl = "";
                                libur = "";
                                tanggal = "";
                                jam_dari = "";
                                jam_sampai = "";
                                tanggal_format = "";
                                catatan = "";

                                if (data_baru[a] != '') {
                                    hasil = data_baru[a].split('--');

                                    id = hasil[1];
                                    tgl = hasil[2];
                                    libur = hasil[3];
                                    tanggal = hasil[4];
                                    jam_dari = hasil[5];
                                    jam_sampai = hasil[6];
                                    tanggal_format = hasil[7];
                                    catatan = typeof(hasil[8]) == 'undefined' ? '' : hasil[8];

                                    if (libur == 1) {
                                        button_class = button_holiday;
                                    } else {
                                        button_class = button;
                                    }

                                    if (catatan != '') {
                                        message_icon = `<i class="ri-mail-line"></i>`;
                                    } else {
                                        message_icon = ``;
                                    }

                                    html += `<td style="background-color: #f4f7fa">
                                                    <button type="button" class="` + button_class + `"
                                                        onClick="show_daily_agenda('` + id + `','` + libur + `','` +
                                        tanggal + `','` + jam_dari + `','` + jam_sampai + `','` + tanggal_format +
                                        `','` +
                                        `','` + catatan + `')">` +
                                        tgl + ` ` + message_icon +
                                        `</button>
                                                </td>`;
                                } else {
                                    html += `<td></td>`;
                                }
                            }

                            html += "</tr>";
                        } else {

                            let hasil = "";

                            let id = "";
                            let libur = "";
                            let tanggal = "";
                            let jam_dari = "";
                            let jam_sampai = "";
                            let tanggal_format = "";
                            let catatan = "";

                            html += `<tr class='text-center' style='height: 100px'>`;

                            for (let a = 0; a <= 6; a++) {
                                id = "";
                                tgl = "";
                                libur = "";
                                tanggal = "";
                                jam_dari = "";
                                jam_sampai = "";
                                tanggal_format = "";
                                catatan = "";

                                if (typeof(has[a]) != 'undefined') {
                                    hasil = has[a].split('--');

                                    id = hasil[1];
                                    tgl = hasil[2];
                                    libur = hasil[3];
                                    tanggal = hasil[4];
                                    jam_dari = hasil[5];
                                    jam_sampai = hasil[6];
                                    tanggal_format = hasil[7];
                                    catatan = typeof(hasil[8]) == 'undefined' ? '' : hasil[8];

                                    if (libur == 1) {
                                        button_class = button_holiday;
                                    } else {
                                        button_class = button;
                                    }

                                    if (catatan != '') {
                                        message_icon = `<i class="ri-mail-line"></i>`;
                                    } else {
                                        message_icon = ``;
                                    }

                                    html += `<td style="background-color: #f4f7fa">
                                    <button type="button" class="` + button_class + `"
                                        onClick="show_daily_agenda('` + id + `','` + libur + `','` +
                                        tanggal + `','` + jam_dari + `','` + jam_sampai + `','` + tanggal_format +
                                        `','` +
                                        `','` + catatan + `')">` +
                                        tgl + ` ` + message_icon +
                                        `</button>
                                </td>`;
                                }
                            }

                            html += `</tr>`;
                        }
                    }

                    $('#dgvList tbody').html(html);
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        function show_agenda() {
            $('#myModal').modal('show');
        }

        function show_daily_agenda(id, libur, tanggal, jam_dari, jam_sampai, tanggal_format, catatan) {
            $('#myModal2').modal('show');

            $('#txtId2').val(id);

            if (libur == 1) {
                $('#chkLibur2').attr('checked', 'checked');
            } else {
                $('#chkLibur2').removeAttr('checked');
            }

            let dari_jam = moment(jam_dari).format('HH:mm');
            let sampai_jam = moment(jam_sampai).format('HH:mm');

            $('#dtpTanggal2').val(tanggal);
            $('#dtpDariJam2').val(dari_jam);
            $('#dtpSampaiJam2').val(sampai_jam);
            $('#txtTanggalFormat2').val(tanggal_format);

            $('#txtCatatan2').val(catatan);
        }
    </script>
@endsection
