<?php

namespace App\Http\Controllers\actasys;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\general\tb_acc_usr as dbUser;
use App\Models\general\tb_acc_ulv as dbLevel;
use App\Models\general\tb_acc_cpy as dbCompany;
use App\Models\general\tb_acc_sfr as dbSoftware;
use App\Models\general\tb_acc_sfr_tab as dbSoftwareTab;
use App\Models\general\tb_acc_sfr_tab_mdl as dbSoftwareModule;
use App\Models\general\tb_acc_ulv_oto as dbOtorisasi;

class LoginController extends BaseController
{
    public function index()
    {
        $this->load_global_session();

        return view('actasys.login');
    }

    function load_global_session()
    {
        request()->session()->flush();
        request()->session()->regenerate();

        $dbSoftware = new dbSoftware();
        $dbCompany = new dbCompany();

        // get software
        $res_software = $dbSoftware
            ->where('id', env('SOFTWARE_ID'))
            ->first();

        request()->session()->put('populus_software_id', $res_software->id);
        request()->session()->put('populus_software_nama', $res_software->nama);
        request()->session()->put('populus_software_tagline', $res_software->tagline);
        request()->session()->put('populus_software_versi', $res_software->versi);
        request()->session()->put('populus_software_copyright', $res_software->copyright);

        // get company
        $res_company = $dbCompany
            ->where('id', env('COMPANY_ID'))
            ->first();

        request()->session()->put('populus_company_id', $res_company->id);
        request()->session()->put('populus_company_nama', $res_company->nama);
        request()->session()->put('populus_company_alamat', $res_company->alamat);
        request()->session()->put('populus_company_telepon', $res_company->telepon);
        request()->session()->put('populus_company_email', $res_company->email);
        request()->session()->put('populus_company_website', $res_company->website);

        // other setup
        request()->session()->put('lockscreen', 1);
        request()->session()->put('theme', 'light');
        request()->session()->put('sidebar', 'sm');
    }

    function load_module($level_id)
    {
        $dbSoftwareTab = new dbSoftwareTab();
        $dbSoftwareModule = new dbSoftwareModule();
        $dbOtorisasi = new dbOtorisasi();

        $software_module = $dbSoftwareModule
            ->join($dbSoftwareTab->get_table() . ' AS A', 'A.id', '=', $dbSoftwareModule->get_table() . '.tab_id')
            ->join($dbOtorisasi->get_table() . ' AS B', 'B.module_id', '=', $dbSoftwareModule->get_table() . '.id')
            ->select(
                $dbSoftwareModule->get_table() . '.*',
                'A.nama AS tab_nama',
                'A.img_icon AS tab_icon',
            )
            ->where('A.status', 1)
            ->where($dbSoftwareModule->get_table() . '.status', 1)
            ->where('A.software_id', env("SOFTWARE_ID"))
            ->where('B.level_id', $level_id)
            ->orderBy('A.urutan')
            ->orderBy($dbSoftwareModule->get_table() . '.urutan')
            ->get();

        $module = [];
        $cc = 0;

        foreach ($software_module as $res_module) {
            $hasil = $res_module->id . ';' . $res_module->nama . ';' . $res_module->link . ';' . $res_module->tab_id . ';' . $res_module->tab_nama . ';' . $res_module->tab_icon;
            $module += [$cc => $hasil];
            $cc++;
        }

        request()->session()->put("module", $module);
    }

    public function login(Request $request)
    {
        $nama = $request->input('nama');
        $password = $request->input('password');

        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'password' => 'required'
            ],
            [
                'nama.required' => 'Tidak boleh kosong!',
                'password.required' => 'Tidak boleh kosong!'
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        } else {
            $dbUser = new dbUser();
            $dbLevel = new dbLevel();

            $post = $dbUser
                ->join($dbLevel->get_table() . ' AS A', 'A.id', '=', $dbUser->get_table() . '.level_id')
                ->select(
                    $dbUser->get_table() . '.*',
                    'A.nama AS level_nama',
                )
                ->where($dbUser->get_table() . '.nama', $nama)
                ->where($dbUser->get_table() . '.status', 1)
                ->where($dbUser->get_table() .  '.password', $password)
                ->get();

            if (count($post) > 0) {
                request()->session()->put('user_id', $post->pluck('id')[0]);
                request()->session()->put('user_nama', $post->pluck('nama')[0]);
                request()->session()->put('level_id', $post->pluck('level_id')[0]);
                request()->session()->put('level_nama', $post->pluck('level_nama')[0]);

                $this->load_module($post->pluck('level_id')[0]);

                return redirect()->intended('dashboard');
            } else {
                return back()->with('formError', 'Login failed!');
            }
        }
    }

    public function logon($nama, $password)
    {
        $dbUser = new dbUser();
        $dbLevel = new dbLevel();

        $post = $dbUser
            ->join($dbLevel->get_table() . ' AS A', 'A.id', '=', $dbUser->get_table() . '.level_id')
            ->select(
                $dbUser->get_table() . '.*',
                'A.nama AS level_nama',
            )
            ->where($dbUser->get_table() . '.nama', $nama)
            ->where($dbUser->get_table() . '.status', 1)
            ->where($dbUser->get_table() .  '.password', $password)
            ->get();

        if (count($post) > 0) {
            $this->load_global_session();

            request()->session()->put('user_id', $post->pluck('id')[0]);
            request()->session()->put('user_nama', $post->pluck('nama')[0]);
            request()->session()->put('level_id', $post->pluck('level_id')[0]);
            request()->session()->put('level_nama', $post->pluck('level_nama')[0]);

            $this->load_module($post->pluck('level_id')[0]);

            return redirect()->intended('dashboard');
        } else {
            return redirect('/');
        }
    }

    public function logout(Request $request)
    {
        request()->session()->flush();
        return redirect('/');
    }
}
