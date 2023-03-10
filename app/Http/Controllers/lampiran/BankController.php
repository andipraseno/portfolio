<?php

namespace App\Http\Controllers\lampiran;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use App\Models\general\tb_mst_bnk as Main;

class BankController extends BaseController
{
    public function __construct()
    {
        $this->middleware("authorizer");
    }

    private $menu = [
        'tab_id' => 13,
        'menu_id' => 39,
    ];

    //********************
    // list
    //********************
    public function index()
    {
        $addon = $this->menu;

        return view('lampiran.bank', $addon);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $main = new Main();

            $post = $main
                ->where('status', 1)
                ->orderBy('nama')
                ->get();

            return Datatables::of($post)->addIndexColumn()->make(true);
        }
    }

    public function attach(Request $request)
    {
        if ($request->ajax()) {
            $dbMain = new Main();

            $post = $dbMain
                ->where('status', 1)
                ->orderBy('nama')
                ->get();

            return Datatables::of($post)->addIndexColumn()->make(true);
        }
    }

    //********************
    // new
    //********************
    public function add()
    {
        $addon = $this->menu;

        return view('lampiran.bankadd', $addon);
    }

    public function add_start(Request $request)
    {
        $main = new Main();

        $nama = $request->input('nama');
        $kode = $request->input('kode');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $main->get_table_conn(),
                'kode' => 'required|unique:' . $main->get_table_conn(),
            ],
            [
                'nama.required' => 'Tidak boleh kosong!',
                'nama.unique' => 'Sudah terdaftar!',
                'kode.required' => 'Tidak boleh kosong!',
                'kode.unique' => 'Sudah terdaftar!',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        } else {
            $post = $main
                ->create([
                    'nama' => $nama,
                    'kode' => $kode,
                    'updated_by' => $by,
                ]);

            return back()->with('formSuccess', 'Data berhasil ditambahkan.');
        }
    }

    //********************
    // edit
    //********************
    public function edit($id)
    {
        $main = new Main();

        $post = $main
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('lampiran.bankedit', $addon);
    }

    public function edit_start(Request $request)
    {
        $main = new Main();

        $id = $request->input('id');
        $nama = $request->input('nama');
        $kode = $request->input('kode');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $main->get_table_conn() . ',nama,' . $id,
                'kode' => 'required|unique:' . $main->get_table_conn() . ',kode,' . $id,
            ],
            [
                'nama.required' => 'Tidak boleh kosong!',
                'nama.unique' => 'Sudah terdaftar!',
                'kode.required' => 'Tidak boleh kosong!',
                'kode.unique' => 'Sudah terdaftar!',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        } else {
            $post = $main
                ->where('id', $id)
                ->update([
                    'nama' => $nama,
                    'kode' => $kode,
                    'updated_by' => $by,
                ]);

            return back()->with('formSuccess', 'Data berhasil diubah.');
        }
    }

    //********************
    // terminate
    //********************
    public function terminate($id)
    {
        $main = new Main();

        $post = $main
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('lampiran.bankterminate', $addon);
    }

    public function terminate_start(Request $request)
    {
        $main = new Main();

        $id = $request->input('id');
        $catatan = $request->input('catatan');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'catatan' => 'required',
            ],
            [
                'catatan.required' => 'Tidak boleh kosong!',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        } else {
            $post = $main
                ->where('id', $id)
                ->update([
                    'status' => 0,
                    'status_note' => $catatan,
                    'updated_by' => $by
                ]);

            return back()->with('formSuccess', 'Data berhasil diubah.');
        }
    }
}
