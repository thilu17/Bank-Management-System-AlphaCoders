<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'username' => session()->get('username'),
            'role'     => session()->get('role'),
        ];
        return view('dashboard/index', $data);
    }
}
