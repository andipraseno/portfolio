<?php

namespace App\Http\Controllers\lampiran;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use App\Models\populus\tb_mst_skw as dbStatusPerkawinan;

class StatusPerkawinanController extends BaseController
{
    public function __construct()
    {
        $this->middleware("authorizer");
    }

    private $menu = [
        'tab_id' => 13,
        'menu_id' => 43,
    ];

    //********************
    // list
    //********************
    public function index()
    {
        $addon = $this->menu;

        return view('lampiran.statusperkawinan', $addon);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $main = new dbStatusPerkawinan();

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
            $dbdbStatusPerkawinan = new dbStatusPerkawinan();

            $post = $dbdbStatusPerkawinan
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

        return view('lampiran.statusperkawinanadd', $addon);
    }

    public function add_start(Request $request)
    {
        $main = new dbStatusPerkawinan();

        $nama = $request->input('nama');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $main->get_table_conn(),
            ],
            [
                'nama.required' => 'Tidak boleh kosong!',
                'nama.unique' => 'Sudah terdaftar!',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        } else {
            $post = $main
                ->create([
                    'nama' => $nama,
                    'created_by' => $by,
                ]);

            return back()->with('formSuccess', 'Data berhasil ditambahkan.');
        }
    }

    //********************
    // edit
    //********************
    public function edit($id)
    {
        $main = new dbStatusPerkawinan();

        $post = $main
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('lampiran.statusperkawinanedit', $addon);
    }

    public function edit_start(Request $request)
    {
        $main = new dbStatusPerkawinan();

        $id = $request->input('id');
        $nama = $request->input('nama');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $main->get_table_conn() . ',nama,' . $id,
            ],
            [
                'nama.required' => 'Tidak boleh kosong!',
                'nama.unique' => 'Sudah terdaftar!',
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
        $main = new dbStatusPerkawinan();

        $post = $main
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('lampiran.statusperkawinanterminate', $addon);
    }

    public function terminate_start(Request $request)
    {
        $main = new dbStatusPerkawinan();

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
