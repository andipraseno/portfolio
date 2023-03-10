<?php

namespace App\Http\Controllers\actasys;

use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
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

        return view("actasys.dashboard", $addon);
    }

    //********************
    // theme style
    //********************
    public function set_theme()
    {
        if (request()->session()->get('theme') == 'dark') {
            request()->session()->put('theme', 'light');
        } else {
            request()->session()->put('theme', 'dark');
        }
    }

    public function set_sidebar()
    {
        if (request()->session()->get('sidebar') == 'sm') {
            request()->session()->put('sidebar', 'lg');
        } else {
            request()->session()->put('sidebar', 'sm');
        }
    }
}
