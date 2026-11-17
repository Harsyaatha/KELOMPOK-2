<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('admin_id')) {
            return redirect()->to('/admin');
        }
        return view('admin/login');
    }

    public function attempt()
    {
        $user = trim((string) $this->request->getPost('username'));
        $pass = (string) $this->request->getPost('password');

        $admin = db_connect()->table('admin')->where('username', $user)->get()->getRowArray();

        if (! $admin || ! password_verify($pass, $admin['password'])) {
            return redirect()->to('/admin/login')->with('error', 'Username atau password salah.');
        }

        session()->regenerate();
        session()->set(['admin_id' => $admin['id'], 'admin_name' => $admin['username']]);

        return redirect()->to('/admin');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}