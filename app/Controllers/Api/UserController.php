<?php

namespace App\Controllers\Api;

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
        $data = $this->userModel->select('users.*, posyandu.nama_posyandu')
                                ->join('posyandu', 'posyandu.id = users.posyandu_id', 'left')
                                ->findAll();
        return $this->response->setJSON(['data' => $data]);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,kader,bidan]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false, 
                'errors' => $this->validator->getErrors()
            ]);
        }

        $input = $this->request->getVar();

        $data = [
            'name'        => $input['name'],
            'username'    => $input['username'],
            'email'       => isset($input['email']) ? $input['email'] : $input['username'] . '@siposka.local',
            'password'    => password_hash($input['password'], PASSWORD_DEFAULT),
            'role'        => $input['role'],
            'posyandu_id' => !empty($input['posyandu_id']) ? $input['posyandu_id'] : null,
            'is_active'   => !empty($input['is_active']) ? true : false
        ];

        $this->userModel->insert($data);
        return $this->response->setJSON(['status' => true, 'message' => 'User berhasil ditambahkan.']);
    }

    public function show($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON($user);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $input = $this->request->getRawInput();
        if (empty($input)) {
            $input = (array) $this->request->getJSON();
        }
        if (empty($input)) {
            $input = $this->request->getVar();
        }

        $rules = [
            'name'     => 'required',
            'username' => 'required|is_unique[users.username,id,'.$id.']',
            'role'     => 'required|in_list[admin,kader,bidan]'
        ];

        if (!empty($input['password'])) {
            $rules['password'] = 'min_length[6]';
        }

        // CI4 validation needs data to be set if not post
        if (!$this->validateData($input, $rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false, 
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'name'        => $input['name'],
            'username'    => $input['username'],
            'role'        => $input['role'],
            'posyandu_id' => !empty($input['posyandu_id']) ? $input['posyandu_id'] : null,
            'is_active'   => !empty($input['is_active']) ? true : false
        ];

        if (!empty($input['password'])) {
            $data['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        return $this->response->setJSON(['status' => true, 'message' => 'User berhasil diupdate.']);
    }

    public function delete($id)
    {
        if ($id == session()->get('id')) {
            return $this->response->setStatusCode(400)->setJSON(['status' => false, 'message' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $this->userModel->delete($id);
        return $this->response->setJSON(['status' => true, 'message' => 'User berhasil dihapus.']);
    }

    public function resetPassword($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $input = $this->request->getRawInput();
        if (empty($input)) {
            $input = (array) $this->request->getJSON();
        }
        if (empty($input)) {
            $input = $this->request->getVar();
        }

        $rules = [
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false, 
                'errors' => $this->validator->getErrors()
            ]);
        }

        $this->userModel->update($id, [
            'password' => password_hash($input['new_password'], PASSWORD_DEFAULT),
        ]);

        return $this->response->setJSON(['status' => true, 'message' => 'Password user ' . esc($user['name']) . ' berhasil direset.']);
    }
}

