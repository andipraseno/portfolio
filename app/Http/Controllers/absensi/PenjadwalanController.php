<?php

namespace App\Http\Controllers\absensi;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use App\Models\populus\tb_mst_jdw_dtl as dbDetail;
use App\Models\populus\tb_mst_jdw as dbPeriode;

class PenjadwalanController extends BaseController
{
    public function __construct()
    {
        $this->middleware("authorizer");
    }

    private $menu = [
        'tab_id' => 15,
        'menu_id' => 49,
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

        return view('absensi.penjadwalan', $addon);
    }

    public function list(Request $request)
    {
        $periode_id = $request->input('periode_id');

        $dbDetail = new dbDetail();

        $post = $dbDetail
            ->select('baris')
            ->selectRaw("GROUP_CONCAT(CONCAT_WS('--', 
                            hari, 
                            id, 
                            day(tanggal),
                            holiday,
                            DATE_FORMAT(tanggal, '%d/%m/%y'),
                            dari_jam,
                            sampai_jam,
                            DATE_FORMAT(tanggal, '%Y/%m/%d'),
                            catatan) ORDER BY CAST(hari AS INT) SEPARATOR '---') AS hasil")
            ->where('header_id', $periode_id)
            ->groupBy('baris')
            ->get();

        return response()->json([
            "data" => $post
        ], 200);
    }

    //********************
    // new
    //********************
    public function add()
    {
        $addon = $this->menu;

        return view('absensi.penjadwalanadd', $addon);
    }

    private $dayList = array(
        'Mon' => 1,
        'Tue' => 2,
        'Wed' => 3,
        'Thu' => 4,
        'Fri' => 5,
        'Sat' => 6,
        'Sun' => 7
    );

    public function add_start(Request $request)
    {
        $dbDetail = new dbDetail();
        $dbPeriode =  new dbPeriode();

        $tahun = $request->input('tahun');
        $dari_jam = $request->input('darijam');
        $sampai_jam = $request->input('sampaijam');
        $baris = 0;

        // save
        for ($a = 1; $a <= 12; $a++) {
            $post = $dbPeriode
                ->create([
                    'tahun' => $tahun,
                    'bulan' => $a
                ]);

            $header_id = $post->id;
            $baris = 1;

            $tanggal = strtotime($tahun . '/' . $a . '/01');
            $tgl_dari = date('Y-m-01', $tanggal);
            $tgl_sampai = date('Y-m-t', $tanggal);
            $end_day = date('d', strtotime($tgl_sampai));

            for ($b = 0; $b < $end_day; $b++) {
                $current_date = date('Y-m-d', strtotime($tgl_dari . ' + ' . $b . ' day'));
                $jam_dari = date('Y-m-d', strtotime($current_date)) . ' ' . $dari_jam;
                $jam_sampai = date('Y-m-d', strtotime($current_date)) . ' ' . $sampai_jam;
                $day = $this->dayList[date('D', strtotime($current_date))];
                $holiday = $day == 7 ? 1 : 0;

                $post = $dbDetail
                    ->create([
                        'header_id' => $header_id,
                        'tanggal' => $current_date,
                        'baris' => $baris,
                        'hari' => $day,
                        'holiday' => $holiday,
                        'dari_jam' => $jam_dari,
                        'sampai_jam' => $jam_sampai,
                    ]);

                if ($day == 7) {
                    $baris++;
                }
            }
        }

        return redirect('/absensi/penjadwalan');
    }

    //********************
    // agenda
    //********************
    public function agenda_save(Request $request)
    {
        $dbDetail = new dbDetail();

        $tgl_dari = strtotime($request->input('tgl_dari'));
        $tgl_sampai = strtotime($request->input('tgl_sampai'));
        $dari_jam = $request->input('darijam');
        $sampai_jam = $request->input('sampaijam');
        $catatan = $request->input('catatan');

        if ($request->input('libur')) {
            $libur = 1;
        } else {
            $libur = 0;
        }

        for ($i = $tgl_dari; $i <= $tgl_sampai; $i = $i + 86400) {
            $this_date = date('Y-m-d', $i);
            $tanggal_format = date('Y-m-d', strtotime($this_date));
            $jam_dari = $tanggal_format . ' ' . $dari_jam;
            $jam_sampai = $tanggal_format . ' ' . $sampai_jam;

            $post = $dbDetail
                ->where('tanggal', $this_date)
                ->update([
                    'holiday' => $libur,
                    'dari_jam' => $jam_dari,
                    'sampai_jam' => $jam_sampai,
                    'catatan' => $catatan
                ]);
        }

        return redirect('/absensi/penjadwalan');
    }

    public function dailyagenda_save(Request $request)
    {
        $dbDetail = new dbDetail();

        $id = $request->input('id2');
        $tanggal_format = $request->input('tanggalformat2');
        $dari_jam = $request->input('darijam2');
        $sampai_jam = $request->input('sampaijam2');
        $catatan = $request->input('catatan2');

        $jam_dari = $tanggal_format . ' ' . $dari_jam;
        $jam_sampai = $tanggal_format . ' ' . $sampai_jam;

        if ($request->input('libur2')) {
            $libur = 1;
        } else {
            $libur = 0;
        }

        $post = $dbDetail
            ->where('id', $id)
            ->update([
                'holiday' => $libur,
                'dari_jam' => $jam_dari,
                'sampai_jam' => $jam_sampai,
                'catatan' => $catatan
            ]);

        return redirect('/absensi/penjadwalan');
    }
}
