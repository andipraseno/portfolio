<?php

namespace App\Http\Controllers\master;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use App\Models\populus\tb_mst_dep as dbDepartment;

class DepartmentController extends BaseController
{
    public function __construct()
    {
        $this->middleware("authorizer");
    }

    private $menu = [
        'tab_id' => 14,
        'menu_id' => 47,
    ];

    //********************
    // list
    //********************
    public function index()
    {
        $addon = $this->menu;

        return view('master.department', $addon);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $dbDepartment = new dbDepartment();

            $post = $dbDepartment
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

        return view('master.departmentadd', $addon);
    }

    public function add_start(Request $request)
    {
        $dbDepartment = new dbDepartment();

        $nama = $request->input('nama');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $dbDepartment->get_table_conn(),
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
            $post = $dbDepartment
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
        $dbDepartment = new dbDepartment();

        $post = $dbDepartment
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('master.departmentedit', $addon);
    }

    public function edit_start(Request $request)
    {
        $dbDepartment = new dbDepartment();

        $id = $request->input('id');
        $nama = $request->input('nama');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $dbDepartment->get_table_conn() . ',nama,' . $id,
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
            $post = $dbDepartment
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
        $dbDepartment = new dbDepartment();

        $post = $dbDepartment
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('master.departmentterminate', $addon);
    }

    public function terminate_start(Request $request)
    {
        $dbDepartment = new dbDepartment();

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
            $post = $dbDepartment
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
