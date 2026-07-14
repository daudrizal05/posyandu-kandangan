<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\BalitaModel;
use App\Models\PosyanduModel;

class BalitaController extends BaseController
{
    protected $balitaModel;
    protected $posyanduModel;

    public function __construct()
    {
        $this->balitaModel = new BalitaModel();
        $this->posyanduModel = new PosyanduModel();
    }

    public function index()
    {
        $data = $this->balitaModel->select('balita.*, posyandu.nama_posyandu')
                                   ->join('posyandu', 'posyandu.id = balita.posyandu_id', 'left')
                                   ->findAll();
        return $this->response->setJSON(['data' => $data]);
    }

    public function store()
    {
        $rules = $this->balitaModel->getValidationRules();

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false, 
                'errors' => $this->validator->getErrors()
            ]);
        }

        $this->balitaModel->insert($this->request->getVar());

        return $this->response->setJSON(['status' => true, 'message' => 'Data balita berhasil ditambahkan.']);
    }

    public function show($id)
    {
        $balita = $this->balitaModel->find($id);
        if (!$balita) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON($balita);
    }

    public function update($id)
    {
        $balita = $this->balitaModel->find($id);
        if (!$balita) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $rules = $this->balitaModel->getValidationRules();
        $rules['nik'] = 'required|max_length[16]|is_unique[balita.nik,id,' . $id . ']';

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false, 
                'errors' => $this->validator->getErrors()
            ]);
        }

        $input = $this->request->getRawInput();
        if (empty($input)) {
            $input = (array) $this->request->getJSON();
        }
        if (empty($input)) {
            $input = $this->request->getVar();
        }

        $this->balitaModel->update($id, $input);

        return $this->response->setJSON(['status' => true, 'message' => 'Data balita berhasil diupdate.']);
    }

    public function delete($id)
    {
        $balita = $this->balitaModel->find($id);
        if (!$balita) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $this->balitaModel->delete($id);

        return $this->response->setJSON(['status' => true, 'message' => 'Data balita berhasil dihapus.']);
    }
}

