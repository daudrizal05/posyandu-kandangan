<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(site_url('/'));
        }
        
        // Ambil data posyandu aktif untuk navbar publik
        $posyanduModel = new \App\Models\PosyanduModel();
        $posyanduList = $posyanduModel->where('status', 'aktif')->orderBy('id', 'ASC')->findAll();
        
        return view('auth/login', [
            'title' => 'Login | SIPOSKA',
            'posyanduList' => $posyanduList
        ]);
    }

    public function process()
    {
        $session  = session();
        $model    = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $model->where('username', $username)->first();

        if (!$user) {
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->to(site_url('login'));
        }

        // PostgreSQL boolean bisa berupa string 't'/'f'
        $isActive = $user['is_active'];
        $isActiveBool = ($isActive === true || $isActive === 't' || $isActive === '1' || $isActive == 1);

        if (!$isActiveBool) {
            $session->setFlashdata('error', 'Akun Anda tidak aktif. Hubungi administrator.');
            return redirect()->to(site_url('login'));
        }

        if (!password_verify($password, $user['password'])) {
            $session->setFlashdata('error', 'Password yang Anda masukkan salah.');
            return redirect()->to(site_url('login'));
        }

        // Login berhasil
        $session->set([
            'id'          => $user['id'],
            'name'        => $user['name'],
            'username'    => $user['username'],
            'email'       => $user['email'],
            'role'        => $user['role'],
            'posyandu_id' => $user['posyandu_id'] ?? null,
            'isLoggedIn'  => true,
        ]);

        return redirect()->to(site_url('/'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('login'));
    }
}