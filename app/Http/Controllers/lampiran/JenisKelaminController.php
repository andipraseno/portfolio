<?php

namespace App\Http\Controllers\lampiran;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use App\Models\populus\tb_mst_jkl as dbJenisKelamin;

class JenisKelaminController extends BaseController
{
    public function __construct()
    {
        $this->middleware("authorizer");
    }

    private $menu = [
        'tab_id' => 13,
        'menu_id' => 41,
    ];

    //********************
    // list
    //********************
    public function index()
    {
        $addon = $this->menu;

        return view('lampiran.jeniskelamin', $addon);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $dbJenisKelamin = new dbJenisKelamin();

            $post = $dbJenisKelamin
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

        return view('lampiran.jeniskelaminadd', $addon);
    }

    public function add_start(Request $request)
    {
        $dbJenisKelamin = new dbJenisKelamin();

        $nama = $request->input('nama');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $dbJenisKelamin->get_table_conn(),
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
            $post = $dbJenisKelamin
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
        $dbJenisKelamin = new dbJenisKelamin();

        $post = $dbJenisKelamin
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('lampiran.jeniskelaminedit', $addon);
    }

    public function edit_start(Request $request)
    {
        $dbJenisKelamin = new dbJenisKelamin();

        $id = $request->input('id');
        $nama = $request->input('nama');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $dbJenisKelamin->get_table_conn() . ',nama,' . $id,
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
            $post = $dbJenisKelamin
                ->where('id', $id)
                ->update([
                    'nama' => $nama,
                    'updated_by' => $by,
                ]);

            return back()->with('formSuccess', 'Data berhasil diubah.');
        }
    }

    //********************
    // teminate
    //********************
    public function terminate($id)
    {
        $dbJenisKelamin = new dbJenisKelamin();

        $post = $dbJenisKelamin
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('lampiran.jeniskelaminterminate', $addon);
    }

    public function terminate_start(Request $request)
    {
        $dbJenisKelamin = new dbJenisKelamin();

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
            $post = $dbJenisKelamin
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
