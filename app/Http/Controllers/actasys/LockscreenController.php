<?php

namespace App\Http\Controllers\actasys;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\general\tb_acc_usr as dbUser;

class LockscreenController extends BaseController
{
    //********************
    // list
    //********************
    public function index()
    {
        request()->session()->put('lockscreen', 2);

        return response()->json([
            "success" => "Y"
        ], 200);
    }

    //********************
    // edit
    //********************
    public function unlock(Request $request)
    {
        $id = request()->session()->get('user_id');
        $password = $request->input('password');

        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required'
            ],
            [
                'password.required' => 'Tidak boleh kosong!'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "success" => "N"
            ], 401);
        } else {
            $dbUser = new dbUser();

            $post = $dbUser
                ->where('id', $id)
                ->where('status', '1')
                ->where('password', $password)
                ->get();

            if (count($post) > 0) {
                request()->session()->put('lockscreen', 1);

                return response()->json([
                    "success" => "Y"
                ], 200);
            } else {
                return response()->json([
                    "success" => "N"
                ], 401);
            }
        }
    }
}
