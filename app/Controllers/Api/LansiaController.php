<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\LansiaModel;
use App\Models\PosyanduModel;

class LansiaController extends BaseController
{
    protected $lansiaModel;
    protected $posyanduModel;

    public function __construct()
    {
        $this->lansiaModel = new LansiaModel();
        $this->posyanduModel = new PosyanduModel();
    }

    public function index()
    {
        $data = $this->lansiaModel
            ->select('lansia.*, posyandu.nama_posyandu')
            ->join('posyandu', 'posyandu.id = lansia.posyandu_id', 'left')
            ->findAll();
        
        return $this->response->setJSON(['data' => $data]);
    }

    public function store()
    {
        $rules = $this->lansiaModel->getValidationRules();

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false, 
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'posyandu_id'         => $this->request->getVar('posyandu_id'),
            'nik'                 => $this->request->getVar('nik'),
            'nama'                => $this->request->getVar('nama'),
            'tempat_lahir'        => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir'       => $this->request->getVar('tanggal_lahir'),
            'alamat'              => $this->request->getVar('alamat'),
            'no_hp'               => $this->request->getVar('no_hp'),
            'status_pernikahan'   => $this->request->getVar('status_pernikahan'),
            'kondisi_kesehatan'   => $this->request->getVar('kondisi_kesehatan'),
            'riwayat_penyakit'    => $this->request->getVar('riwayat_penyakit'),
            'umur'                => $this->request->getVar('umur'),
            'lingkar_lengan_atas' => $this->request->getVar('lingkar_lengan_atas'),
            'bb'                  => $this->request->getVar('bb'),
            'tb'                  => $this->request->getVar('tb'),
            'lingkar_pinggang'    => $this->request->getVar('lingkar_pinggang'),
            'imt'                 => $this->request->getVar('imt'),
            'no_bpjs'             => $this->request->getVar('no_bpjs'),
            'keluhan'             => $this->request->getVar('keluhan'),
            'tensi'               => $this->request->getVar('tensi'),
            'obat'                => $this->request->getVar('obat'),
        ];

        $this->lansiaModel->insert($data);
        return $this->response->setJSON(['status' => true, 'message' => 'Data lansia berhasil ditambahkan.']);
    }

    public function show($id)
    {
        $data = $this->lansiaModel->find($id);
        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON($data);
    }

    public function update($id)
    {
        $lansia = $this->lansiaModel->find($id);
        if (!$lansia) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $rules = $this->lansiaModel->getValidationRules();
        // Allow updating own NIK
        $rules['nik'] = 'required|max_length[16]|is_unique[lansia.nik,id,' . $id . ']';

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'posyandu_id'         => $this->request->getVar('posyandu_id'),
            'nik'                 => $this->request->getVar('nik'),
            'nama'                => $this->request->getVar('nama'),
            'tempat_lahir'        => $this->request->getVar('tempat_lahir'),
            'tanggal_lahir'       => $this->request->getVar('tanggal_lahir'),
            'alamat'              => $this->request->getVar('alamat'),
            'no_hp'               => $this->request->getVar('no_hp'),
            'status_pernikahan'   => $this->request->getVar('status_pernikahan'),
            'kondisi_kesehatan'   => $this->request->getVar('kondisi_kesehatan'),
            'riwayat_penyakit'    => $this->request->getVar('riwayat_penyakit'),
            'umur'                => $this->request->getVar('umur'),
            'lingkar_lengan_atas' => $this->request->getVar('lingkar_lengan_atas'),
            'bb'                  => $this->request->getVar('bb'),
            'tb'                  => $this->request->getVar('tb'),
            'lingkar_pinggang'    => $this->request->getVar('lingkar_pinggang'),
            'imt'                 => $this->request->getVar('imt'),
            'no_bpjs'             => $this->request->getVar('no_bpjs'),
            'keluhan'             => $this->request->getVar('keluhan'),
            'tensi'               => $this->request->getVar('tensi'),
            'obat'                => $this->request->getVar('obat'),
        ];

        $this->lansiaModel->update($id, $data);
        return $this->response->setJSON(['status' => true, 'message' => 'Data lansia berhasil diupdate.']);
    }

    public function delete($id)
    {
        $this->lansiaModel->delete($id);
        return $this->response->setJSON(['status' => true, 'message' => 'Data lansia berhasil dihapus.']);
    }
}
