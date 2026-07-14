<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\IbuHamilModel;

class IbuHamilController extends BaseController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new IbuHamilModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $posyandu_id = session()->get('posyandu_id');

        if (in_array($role, ['kader', 'bidan']) && $posyandu_id) {
            $data = $this->model->where('posyandu_id', $posyandu_id)->findAll();
        } else {
            $data = $this->model->getIbuHamilWithPosyandu();
        }
        return $this->respond(['data' => $data]);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Data tidak ditemukan');
    }

    public function store()
    {
        $rules = [
            'nik' => 'required|is_unique[ibu_hamil.nik]',
            'nama_ibu' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = $this->request->getPost();
        
        // Auto assign posyandu_id for kader/bidan
        if (in_array(session()->get('role'), ['kader', 'bidan']) && session()->get('posyandu_id')) {
            $data['posyandu_id'] = session()->get('posyandu_id');
        }

        $this->model->insert($data);
        return $this->respondCreated(['message' => 'Data Ibu Hamil berhasil ditambahkan']);
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if (empty($data)) {
            $data = $this->request->getPost();
        }
        
        $rules = [
            'nik' => "required|is_unique[ibu_hamil.nik,id,{$id}]",
            'nama_ibu' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $this->model->update($id, $data);
        return $this->respond(['message' => 'Data Ibu Hamil berhasil diupdate']);
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Data Ibu Hamil berhasil dihapus']);
        }
        return $this->failNotFound('Data tidak ditemukan');
    }
}
