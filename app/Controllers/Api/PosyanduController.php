<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PosyanduModel;

class PosyanduController extends BaseController
{
    protected $posyanduModel;

    public function __construct()
    {
        $this->posyanduModel = new PosyanduModel();
    }

    public function index()
    {
        $data = $this->posyanduModel->findAll();
        $db = \Config\Database::connect();

        // Attach summary counts for each posyandu
        foreach ($data as &$posyandu) {
            $pid = $posyandu['id'];
            $ringkasan = [];
            $tables = ['balita', 'ibu_hamil', 'remaja', 'usia_produktif', 'lansia'];
            foreach ($tables as $tbl) {
                if ($db->tableExists($tbl)) {
                    $ringkasan[$tbl] = $db->table($tbl)->where('posyandu_id', $pid)->countAllResults();
                } else {
                    $ringkasan[$tbl] = 0;
                }
            }
            $posyandu['ringkasan'] = $ringkasan;
        }
        unset($posyandu);

        return $this->response->setJSON(['data' => $data]);
    }

    public function store()
    {
        // Get input from POST body or JSON body
        $input = $this->request->getPost();
        if (empty($input)) {
            $input = $this->request->getJSON(true) ?? [];
        }

        // Validate only required fields, foto is optional from SPA
        $rules = [
            'nama_posyandu' => 'required|max_length[150]',
            'alamat'        => 'permit_empty',
            'status'        => 'permit_empty|in_list[aktif,nonaktif]',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/posyandu', $namaFoto);
        }

        $data = [
            'nama_posyandu'    => $input['nama_posyandu'] ?? null,
            'alamat'           => $input['alamat'] ?? null,
            'desa_kelurahan'   => $input['desa_kelurahan'] ?? null,
            'kecamatan'        => $input['kecamatan'] ?? null,
            'nama_ketua_kader' => $input['nama_ketua_kader'] ?? null,
            'kontak'           => $input['kontak'] ?? null,
            'latitude'         => $input['latitude'] ?? null,
            'longitude'        => $input['longitude'] ?? null,
            'status'           => $input['status'] ?? 'aktif',
        ];

        if ($namaFoto) {
            $data['foto'] = $namaFoto;
        }

        $this->posyanduModel->insert($data);
        return $this->response->setJSON(['status' => true, 'message' => 'Data posyandu berhasil ditambahkan.']);
    }

    public function show($id)
    {
        $posyandu = $this->posyanduModel->find($id);
        if (!$posyandu) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON($posyandu);
    }

    public function update($id)
    {
        $posyandu = $this->posyanduModel->find($id);
        if (!$posyandu) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        // Get input from POST, PUT, or JSON body
        $input = $this->request->getPost();
        if (empty($input)) {
            $input = $this->request->getJSON(true) ?? [];
        }
        if (empty($input)) {
            parse_str(file_get_contents('php://input'), $input);
        }

        $rules = [
            'nama_posyandu' => 'required|max_length[150]',
            'alamat'        => 'permit_empty',
            'status'        => 'permit_empty|in_list[aktif,nonaktif]',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = $posyandu['foto'];

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if ($namaFoto && file_exists(FCPATH . 'uploads/posyandu/' . $namaFoto)) {
                unlink(FCPATH . 'uploads/posyandu/' . $namaFoto);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/posyandu', $namaFoto);
        }

        $data = [
            'nama_posyandu'    => $input['nama_posyandu'] ?? $posyandu['nama_posyandu'],
            'alamat'           => $input['alamat'] ?? $posyandu['alamat'],
            'desa_kelurahan'   => $input['desa_kelurahan'] ?? $posyandu['desa_kelurahan'],
            'kecamatan'        => $input['kecamatan'] ?? $posyandu['kecamatan'],
            'nama_ketua_kader' => $input['nama_ketua_kader'] ?? $posyandu['nama_ketua_kader'],
            'kontak'           => $input['kontak'] ?? $posyandu['kontak'],
            'latitude'         => $input['latitude'] ?? $posyandu['latitude'],
            'longitude'        => $input['longitude'] ?? $posyandu['longitude'],
            'status'           => $input['status'] ?? $posyandu['status'],
            'foto'             => $namaFoto
        ];

        $this->posyanduModel->update($id, $data);
        return $this->response->setJSON(['status' => true, 'message' => 'Data posyandu berhasil diupdate.']);
    }

    public function delete($id)
    {
        $posyandu = $this->posyanduModel->find($id);
        if (!$posyandu) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        if ($posyandu['foto'] && file_exists(FCPATH . 'uploads/posyandu/' . $posyandu['foto'])) {
            unlink(FCPATH . 'uploads/posyandu/' . $posyandu['foto']);
        }

        $this->posyanduModel->delete($id);
        return $this->response->setJSON(['status' => true, 'message' => 'Data posyandu berhasil dihapus.']);
    }
}
