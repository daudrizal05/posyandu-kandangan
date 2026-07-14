<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\DownloadModel;

class DownloadController extends BaseController
{
    protected $downloadModel;

    public function __construct()
    {
        $this->downloadModel = new DownloadModel();
    }

    public function index()
    {
        $data = $this->downloadModel->findAll();
        return $this->response->setJSON(['data' => $data]);
    }

    public function store()
    {
        $rules = [
            'judul_file' => 'required',
            'kategori'   => 'required',
            'file'       => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $file = $this->request->getFile('file');
        $namaFile = $file->getRandomName();
        $file->move(FCPATH . 'uploads/dokumen', $namaFile);

        $data = [
            'judul_file'     => $this->request->getPost('judul_file'),
            'kategori'       => $this->request->getPost('kategori'),
            'nama_file'      => $namaFile,
            'tanggal_upload' => date('Y-m-d')
        ];

        $this->downloadModel->insert($data);
        return $this->response->setJSON(['status' => true, 'message' => 'Dokumen berhasil diupload']);
    }

    public function show($id)
    {
        $data = $this->downloadModel->find($id);
        if (!$data) return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Not found']);
        return $this->response->setJSON($data);
    }

    public function update($id)
    {
        $dokumen = $this->downloadModel->find($id);
        if (!$dokumen) return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Not found']);

        $rules = [
            'judul_file' => 'required',
            'kategori'   => 'required',
        ];

        $file = $this->request->getFile('file');
        if ($file && $file->isValid()) {
            $rules['file'] = 'max_size[file,10240]|ext_in[file,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar]';
        }

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $namaFile = $dokumen['nama_file'];
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move(FCPATH . 'uploads/dokumen', $namaFile);
            // Optionally delete old file
            @unlink(FCPATH . 'uploads/dokumen/' . $dokumen['nama_file']);
        }

        $data = [
            'judul_file'     => $this->request->getPost('judul_file'),
            'kategori'       => $this->request->getPost('kategori'),
            'nama_file'      => $namaFile
        ];

        $this->downloadModel->update($id, $data);
        return $this->response->setJSON(['status' => true, 'message' => 'Dokumen berhasil diupdate']);
    }

    public function delete($id)
    {
        $dokumen = $this->downloadModel->find($id);
        if ($dokumen) {
            @unlink(FCPATH . 'uploads/dokumen/' . $dokumen['nama_file']);
            $this->downloadModel->delete($id);
        }
        return $this->response->setJSON(['status' => true, 'message' => 'Data berhasil dihapus']);
    }
}
