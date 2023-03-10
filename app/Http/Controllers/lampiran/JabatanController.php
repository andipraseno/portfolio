<?php

namespace App\Http\Controllers\lampiran;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use App\Models\populus\tb_mst_jbt as dbJabatan;

class JabatanController extends BaseController
{
    public function __construct()
    {
        $this->middleware("authorizer");
    }

    private $menu = [
        'tab_id' => 13,
        'menu_id' => 45,
    ];

    //********************
    // list
    //********************
    public function index()
    {
        $addon = $this->menu;

        return view('lampiran.jabatan', $addon);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $dbJabatan = new dbJabatan();

            $post = $dbJabatan
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

        return view('lampiran.jabatanadd', $addon);
    }

    public function add_start(Request $request)
    {
        $dbJabatan = new dbJabatan();

        $nama = $request->input('nama');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $dbJabatan->get_table_conn(),
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
            $post = $dbJabatan
                ->create([
                    'nama' => $nama,
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
        $dbJabatan = new dbJabatan();

        $post = $dbJabatan
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('lampiran.jabatanedit', $addon);
    }

    public function edit_start(Request $request)
    {
        $dbJabatan = new dbJabatan();

        $id = $request->input('id');
        $nama = $request->input('nama');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $dbJabatan->get_table_conn() . ',nama,' . $id,
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
            $post = $dbJabatan
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
        $dbJabatan = new dbJabatan();

        $post = $dbJabatan
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('lampiran.jabatanterminate', $addon);
    }

    public function terminate_start(Request $request)
    {
        $dbJabatan = new dbJabatan();

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
            $post = $dbJabatan
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
