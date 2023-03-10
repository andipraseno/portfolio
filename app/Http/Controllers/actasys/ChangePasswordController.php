<?php

namespace App\Http\Controllers\actasys;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\general\tb_acc_usr as dbUser;

class ChangePasswordController extends BaseController
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
        $addon = $this->menu;

        return view('actasys.changepassword', $addon);
    }

    //********************
    // edit
    //********************
    public function save(Request $request)
    {
        $id = request()->session()->get('user_id');
        $password1 = $request->input('txtPassword1');
        $password2 = $request->input('txtPassword2');
        $password3 = $request->input('txtPassword3');

        $validator = Validator::make(
            $request->all(),
            [
                'txtPassword1' => 'required',
                'txtPassword2' => 'required',
                'txtPassword3' => 'required'
            ],
            [
                'txtPassword1.unique' => 'Tidak boleh kosong!',
                'txtPassword2.unique' => 'Tidak boleh kosong!',
                'txtPassword3.unique' => 'Tidak boleh kosong!'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        } else {
            $dbUser = new dbUser();

            $post = $dbUser
                ->where('id', $id)
                ->where('status', '1')
                ->where('password', $password1)
                ->get();

            if (count($post) > 0) {
                if ($password2 == $password3) {
                    $post = $dbUser
                        ->where('id', $id)
                        ->update([
                            'password' => $password2
                        ]);

                    return back()->with('loginSuccess', 'Password berhasil diubah. Anda akan memakai password baru setelah login ulang!');
                } else {
                    return back()->with('loginError', 'Password baru tidak sama!');
                }
            } else {
                return back()->with('loginError', 'Password salah!');
            }
        }
    }
}
