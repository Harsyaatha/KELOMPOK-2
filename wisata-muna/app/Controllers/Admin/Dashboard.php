<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = db_connect();
        return view('admin/dashboard', [
            'jmlNode'  => $db->table('node')->countAllResults(),
            'jmlJarak' => $db->table('jarak')->countAllResults(),
            'jmlAdmin' => $db->table('admin')->countAllResults(),
        ]);
    }
}