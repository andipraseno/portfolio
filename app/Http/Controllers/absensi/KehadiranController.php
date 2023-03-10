<?php

namespace App\Http\Controllers\absensi;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use App\Models\populus\tb_mst_kry as dbKaryawan;
use App\Models\populus\tb_mst_jbt as dbJabatan;
use App\Models\populus\tb_mst_dep as dbDepartment;
use App\Models\populus\tb_mst_jdw_dtl as dbJadwal;
use App\Models\populus\tb_trs_ppl_abs as dbKehadiran;
use App\Models\populus\tb_mst_abs as dbTipeAbsen;
use App\Models\populus\tb_mst_jdw as dbPeriode;

class KehadiranController extends BaseController
{
    public function __construct()
    {
        $this->middleware("authorizer");
    }

    private $menu = [
        'tab_id' => 15,
        'menu_id' => 50,
    ];

    //********************
    // list
    //********************
    public function index()
    {
        $dbPeriode = new dbPeriode();

        $periode = $dbPeriode
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $post = $dbPeriode
            ->where('tahun', date('Y'))
            ->where('bulan', date('m'))
            ->get();

        $selected_periode = '';

        if (count($post) > 0) {
            $selected_periode = $post->pluck('id')[0];
        }

        $addon = $this->menu;

        $addon += ["periode" => $periode, 'selected_periode' => $selected_periode];

        return view('absensi.kehadiran', $addon);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $dbKaryawan = new dbKaryawan();
            $dbJabatan = new dbJabatan();
            $dbDepartment = new dbDepartment();
            $dbJadwal = new dbJadwal();
            $dbKehadiran = new dbKehadiran();
            $dbTipeAbsen = new dbTipeAbsen();

            $periode_id = $request->input('periode_id');

            $post = $dbKaryawan
                ->join($dbDepartment->get_table(), $dbKaryawan->get_table() . '.department_id', '=', $dbDepartment->get_table() . '.id')
                ->join($dbJabatan->get_table(), $dbKaryawan->get_table() . '.jabatan_id', '=', $dbJabatan->get_table() . '.id')
                ->crossJoin($dbJadwal->get_table())
                ->leftJoin($dbKehadiran->get_table(), function ($join) use ($dbKehadiran, $dbKaryawan, $dbJadwal) {
                    $join->on($dbKehadiran->get_table() . '.karyawan_id', '=', $dbKaryawan->get_table() . '.id')
                        ->on($dbKehadiran->get_table() . '.jadwal_id', '=', $dbJadwal->get_table() . '.id');
                })
                ->leftJoin($dbTipeAbsen->get_table(), $dbKehadiran->get_table() . '.tipe_id', '=', $dbTipeAbsen->get_table() . '.id')
                ->select(
                    $dbKaryawan->get_table() . '.*',
                    $dbDepartment->get_table() . '.nama AS department_nama',
                    $dbJabatan->get_table() . '.nama AS jabatan_nama',
                    $dbJadwal->get_table() . '.id AS jadwal_id',
                )
                ->selectRaw($dbJadwal->get_table() . ".holiday")
                ->selectRaw("COALESCE(" . $dbTipeAbsen->get_table() . ".id, '') AS tipe_id")
                ->selectRaw("COALESCE(" . $dbTipeAbsen->get_table() . ".nama, '') AS tipe_nama")
                ->selectRaw("DATE_FORMAT(" . $dbJadwal->get_table() . ".dari_jam, '%d/%m/%y') AS tanggal")
                ->selectRaw("CONCAT(DATE_FORMAT(" . $dbJadwal->get_table() . ".dari_jam, '%H:%i'), ' s/d ', 
                            DATE_FORMAT(" . $dbJadwal->get_table() . ".sampai_jam, '%H:%i')) AS jam")
                ->selectRaw("CONCAT((CASE WHEN " . $dbKehadiran->get_table() . ".jam_dari IS NULL THEN '?' ELSE DATE_FORMAT(" . $dbKehadiran->get_table() . ".jam_dari, '%H:%i') END), ' s/d ',
                            (CASE WHEN " . $dbKehadiran->get_table() . ".jam_sampai IS NULL THEN '?' ELSE DATE_FORMAT(" . $dbKehadiran->get_table() . ".jam_sampai, '%H:%i') END)) AS absen")
                ->where($dbKaryawan->get_table() . '.status', 1)
                ->where($dbJadwal->get_table() . '.header_id', $periode_id)
                ->orderBy($dbKaryawan->get_table() . '.id', 'ASC')
                ->orderBy($dbJadwal->get_table() . '.tanggal', 'ASC')
                ->get();

            return Datatables::of($post)->addIndexColumn()->make(true);
        }
    }

    //********************
    // edit
    //********************
    public function edit($id, $jadwal_id)
    {
        $dbKaryawan = new dbKaryawan();
        $dbJadwal = new dbJadwal();
        $dbKehadiran = new dbKehadiran();
        $dbTipeAbsen = new dbTipeAbsen();

        $tipe = $dbTipeAbsen
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        $post = $dbKaryawan
            ->crossJoin($dbJadwal->get_table())
            ->leftJoin($dbKehadiran->get_table(), function ($join) use ($dbKehadiran, $dbKaryawan, $dbJadwal) {
                $join->on($dbKehadiran->get_table() . '.karyawan_id', '=', $dbKaryawan->get_table() . '.id')
                    ->on($dbKehadiran->get_table() . '.jadwal_id', '=', $dbJadwal->get_table() . '.id');
            })
            ->leftJoin($dbTipeAbsen->get_table(), $dbKehadiran->get_table() . '.tipe_id', '=', $dbTipeAbsen->get_table() . '.id')
            ->select(
                $dbKaryawan->get_table() . '.*',
                $dbJadwal->get_table() . '.id AS jadwal_id',
                $dbJadwal->get_table() . '.dari_jam',
                $dbJadwal->get_table() . '.sampai_jam',
            )
            ->selectRaw("COALESCE(" . $dbTipeAbsen->get_table() . ".id, '') AS tipe_id")
            ->selectRaw("COALESCE(" . $dbTipeAbsen->get_table() . ".nama, '') AS tipe_nama")
            ->selectRaw("DATE_FORMAT(" . $dbJadwal->get_table() . ".dari_jam, '%d/%m/%y') AS tanggal")
            ->selectRaw("CONCAT(DATE_FORMAT(" . $dbJadwal->get_table() . ".dari_jam, '%H:%i'), ' s/d ', 
            DATE_FORMAT(" . $dbJadwal->get_table() . ".sampai_jam, '%H:%i')) AS jam")
            ->selectRaw("CONCAT((CASE WHEN " . $dbKehadiran->get_table() . ".jam_dari IS NULL THEN '?' ELSE DATE_FORMAT(" . $dbKehadiran->get_table() . ".jam_dari, '%H:%i') END), ' s/d ',
            (CASE WHEN " . $dbKehadiran->get_table() . ".jam_sampai IS NULL THEN '?' ELSE DATE_FORMAT(" . $dbKehadiran->get_table() . ".jam_sampai, '%H:%i') END)) AS absen")
            ->where($dbKaryawan->get_table() . '.status', 1)
            ->where($dbKaryawan->get_table() . '.id', $id)
            ->where($dbJadwal->get_table() . '.id', $jadwal_id)
            ->whereRaw('year(' . $dbJadwal->get_table() . '.tanggal) = 2023 AND
                            month(' . $dbJadwal->get_table() . '.tanggal) = 1')
            ->orderBy($dbKaryawan->get_table() . '.id', 'ASC')
            ->orderBy($dbJadwal->get_table() . '.tanggal', 'ASC')
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post, "tipe" => $tipe];

        return view('absensi.kehadiranedit', $addon);
    }

    public function edit_start(Request $request)
    {
        $dbKehadiran = new dbKehadiran();

        $karyawan_id = $request->input('karyawan_id');
        $jadwal_id = $request->input('jadwal_id');
        $tipe = $request->input('tipe');
        $dari_jam = $request->input('dari_jam');
        $sampai_jam = $request->input('sampai_jam');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'tipe' => 'required',
            ],
            [
                'tipe.required' => 'Belum dipilih!',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        } else {
            $post = $dbKehadiran
                ->insert([
                    'karyawan_id' => $karyawan_id,
                    'jadwal_id' => $jadwal_id,
                    'tipe_id' => $tipe,
                    'jam_dari' => $dari_jam,
                    'jam_sampai' => $sampai_jam
                ]);

            return back()->with('formSuccess', 'Data berhasil diubah.');
        }
    }
}
