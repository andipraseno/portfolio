<?php

namespace App\Http\Controllers\master;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use App\Models\populus\tb_mst_kry as dbKaryawan;
use App\Models\populus\tb_mst_jbt as dbJabatan;
use App\Models\populus\tb_mst_dep as dbDepartment;

class KaryawanController extends BaseController
{
    public function __construct()
    {
        $this->middleware("authorizer");
    }

    private $menu = [
        'tab_id' => 14,
        'menu_id' => 48,
    ];

    //********************
    // list
    //********************
    public function index()
    {
        $addon = $this->menu;

        return view('master.karyawan', $addon);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $dbKaryawan = new dbKaryawan();
            $dbJabatan = new dbJabatan();
            $dbDepartment = new dbDepartment();

            $post = $dbKaryawan
                ->join($dbDepartment->get_table(), $dbKaryawan->get_table() . '.department_id', '=', $dbDepartment->get_table() . '.id')
                ->join($dbJabatan->get_table(), $dbKaryawan->get_table() . '.jabatan_id', '=', $dbJabatan->get_table() . '.id')
                ->select(
                    $dbKaryawan->get_table() . '.*',
                    $dbDepartment->get_table() . '.nama AS department_nama',
                    $dbJabatan->get_table() . '.nama AS jabatan_nama',
                )
                ->where($dbKaryawan->get_table() . '.status', 1)
                ->get();

            return Datatables::of($post)->addIndexColumn()->make(true);
        }
    }

    //********************
    // new
    //********************
    public function add()
    {
        $dbDepartment = new dbDepartment();
        $dbJabatan = new dbJabatan();

        $jabatan = $dbJabatan
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        $department = $dbDepartment
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        $addon = $this->menu;

        $addon += ["jabatan" => $jabatan, "department" => $department];

        return view('master.karyawanadd', $addon);
    }

    public function add_start(Request $request)
    {
        $dbKaryawan = new dbKaryawan();

        $nama = $request->input('nama');
        $kode = $request->input('kode');
        $pin = $request->input('pin');
        $department_id = $request->input('department');
        $jabatan_id = $request->input('jabatan');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $dbKaryawan->get_table_conn(),
                'kode' => 'required|unique:' . $dbKaryawan->get_table_conn(),
                'pin' => 'required',
                'department' => 'required',
                'jabatan' => 'required',
            ],
            [
                'nama.required' => 'Tidak boleh kosong!',
                'nama.unique' => 'Sudah terdaftar!',
                'kode.required' => 'Tidak boleh kosong!',
                'kode.unique' => 'Sudah terdaftar!',
                'pin.required' => 'Tidak boleh kosong!',
                'department.required' => 'Tidak boleh kosong!',
                'jabatan.required' => 'Tidak boleh kosong!',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        } else {
            $post = $dbKaryawan
                ->create([
                    'nama' => $nama,
                    'kode' => $kode,
                    'pin' => $pin,
                    'department_id' => $department_id,
                    'jabatan_id' => $jabatan_id,
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
        $dbKaryawan = new dbKaryawan();
        $dbDepartment = new dbDepartment();
        $dbJabatan = new dbJabatan();

        $jabatan = $dbJabatan
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        $department = $dbDepartment
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        $post = $dbKaryawan
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["jabatan" => $jabatan, "department" => $department, "post" => $post];

        return view('master.karyawanedit', $addon);
    }

    public function edit_start(Request $request)
    {
        $dbKaryawan = new dbKaryawan();

        $id = $request->input('id');
        $nama = $request->input('nama');
        $kode = $request->input('kode');
        $pin = $request->input('pin');
        $department_id = $request->input('department');
        $jabatan_id = $request->input('jabatan');
        $by = $request->session()->get('user_nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $dbKaryawan->get_table_conn() . ',nama,' . $id,
                'kode' => 'required|unique:' . $dbKaryawan->get_table_conn() . ',kode,' . $id,
                'pin' => 'required',
                'department' => 'required',
                'jabatan' => 'required',
            ],
            [
                'nama.required' => 'Tidak boleh kosong!',
                'nama.unique' => 'Sudah terdaftar!',
                'kode.required' => 'Tidak boleh kosong!',
                'kode.unique' => 'Sudah terdaftar!',
                'pin.required' => 'Tidak boleh kosong!',
                'department.required' => 'Tidak boleh kosong!',
                'jabatan.required' => 'Tidak boleh kosong!',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        } else {
            $post = $dbKaryawan
                ->where('id', $id)
                ->update([
                    'nama' => $nama,
                    'kode' => $kode,
                    'pin' => $pin,
                    'department_id' => $department_id,
                    'jabatan_id' => $jabatan_id,
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
        $dbKaryawan = new dbKaryawan();

        $post = $dbKaryawan
            ->where('id', $id)
            ->get();

        $addon = $this->menu;

        $addon += ["post" => $post];

        return view('master.karyawanterminate', $addon);
    }

    public function terminate_start(Request $request)
    {
        $dbKaryawan = new dbKaryawan();

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
            $post = $dbKaryawan
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
