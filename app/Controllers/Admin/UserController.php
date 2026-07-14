<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PosyanduModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $posyanduModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->posyanduModel = new PosyanduModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->select('users.*, posyandu.nama_posyandu')
                                       ->join('posyandu', 'posyandu.id = users.posyandu_id', 'left')
                                       ->paginate(10, 'users'),
            'pager' => $this->userModel->pager
        ];

        return view('admin/user/index', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah User',
            'posyandu' => $this->posyanduModel->orderBy('id', 'ASC')->findAll()
        ];

        return view('admin/user/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required',
            'username' => 'required|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,kader,bidan]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'        => $this->request->getPost('role'),
            'posyandu_id' => $this->request->getPost('posyandu_id') ?: null,
            'is_active'   => $this->request->getPost('is_active') ? true : false
        ];

        $this->userModel->insert($data);

        return redirect()->to(site_url('admin/user'))->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'    => 'Edit User',
            'user'     => $user,
            'posyandu' => $this->posyanduModel->orderBy('id', 'ASC')->findAll()
        ];

        return view('admin/user/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'name'     => 'required',
            'username' => 'required|is_unique[users.username,id,'.$id.']',
            'email'    => 'required|valid_email|is_unique[users.email,id,'.$id.']',
            'role'     => 'required|in_list[admin,kader,bidan]'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'role'        => $this->request->getPost('role'),
            'posyandu_id' => $this->request->getPost('posyandu_id') ?: null,
            'is_active'   => $this->request->getPost('is_active') ? true : false
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        return redirect()->to(site_url('admin/user'))->with('success', 'User berhasil diupdate.');
    }

    public function delete($id)
    {
        if ($id == session()->get('id')) {
            return redirect()->back()->with('errors', ['Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->userModel->delete($id);

        return redirect()->to(site_url('admin/user'))->with('success', 'User berhasil dihapus.');
    }

    public function resetPassword($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->update($id, [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to(site_url('admin/user'))->with('success', 'Password user ' . esc($user['name']) . ' berhasil direset.');
    }
}
