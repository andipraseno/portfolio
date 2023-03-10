<?php

namespace App\Http\Controllers\actasys;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\general\tb_acc_usr as dbUser;
use App\Models\general\tb_acc_ulv as dbLevel;

class UserProfileController extends BaseController
{
    public function __construct()
    {
        $this->middleware("authorizer");
    }

    private $menu = [
        'tab_id' => 0,
        'menu_id' => 0,
    ];

    //********************
    // list
    //********************
    public function index()
    {
        $dbUser = new dbUser();
        $dbLevel = new dbLevel();

        $id = request()->session()->get('user_id');

        $post = $dbUser
            ->join($dbLevel->get_table(), $dbUser->get_table() . '.level_id', '=', $dbLevel->get_table() . '.id')
            ->select(
                $dbUser->get_table() . '.*',
                $dbLevel->get_table() . '.nama AS level_nama',
            )
            ->where($dbUser->get_table() . '.id', $id)
            ->where($dbUser->get_table() . '.status', 1)
            ->get();

        $addon = $this->menu;

        $addon += ['post' => $post];

        return view('actasys.userprofile', $addon);
    }

    //********************
    // edit
    //********************
    public function save(Request $request)
    {
        $dbUser = new dbUser();

        $id = request()->session()->get('user_id');
        $nama = $request->input('nama');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|unique:' . $dbUser->get_table_conn() . ',nama,' . $id
            ],
            [
                'nama.required' => 'Tidak boleh kosong!',
                'nama.unique' => 'Sudah terdaftar!'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        } else {
            $post = $dbUser
                ->where('id', $id)
                ->update(
                    [
                        'nama' => $nama
                    ]
                );

            return back()->with('formSuccess', 'Data berhasil diubah.');
        }
    }
}
