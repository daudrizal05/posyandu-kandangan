<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PengukuranModel;
use App\Models\BalitaModel;
use App\Models\PosyanduModel;

class PengukuranController extends BaseController
{
    protected $pengukuranModel;
    protected $balitaModel;
    protected $posyanduModel;

    public function __construct()
    {
        helper('StatusGizi');
        $this->pengukuranModel = new PengukuranModel();
        $this->balitaModel = new BalitaModel();
        $this->posyanduModel = new PosyanduModel();
    }

    public function index()
    {
        $data = $this->pengukuranModel->select('pengukuran.*, balita.nama_balita, balita.nik, posyandu.nama_posyandu')
                                       ->join('balita', 'balita.id = pengukuran.balita_id')
                                       ->join('posyandu', 'posyandu.id = pengukuran.posyandu_id')
                                       ->orderBy('pengukuran.tanggal_pengukuran', 'DESC')
                                       ->findAll();
        return $this->response->setJSON(['data' => $data]);
    }

    public function store()
    {
        // Validasi tanpa status_gizi (dihitung otomatis)
        $rules = [
            'balita_id'          => 'required|numeric',
            'posyandu_id'        => 'required|numeric',
            'tanggal_pengukuran' => 'required|valid_date',
            'berat_badan'        => 'required|numeric',
            'tinggi_badan'       => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => false, 
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = $this->request->getVar();

        // Hitung usia dalam bulan dari tanggal lahir balita
        $balita = $this->balitaModel->find($data['balita_id']);
        if ($balita) {
            $tglLahir   = new \DateTime($balita['tanggal_lahir']);
            $tglUkur    = new \DateTime($data['tanggal_pengukuran']);
            $diff       = $tglLahir->diff($tglUkur);
            $usia_bulan = ($diff->y * 12) + $diff->m;
            $data['usia_bulan'] = $usia_bulan;

            // Kalkulasi status gizi otomatis (WHO 2006)
            $gizi = hitung_status_gizi(
                (float)$data['berat_badan'],
                (float)$data['tinggi_badan'],
                $usia_bulan,
                $balita['jenis_kelamin']
            );
            $data['status_gizi']  = $gizi['status_gizi'];
            $data['zscore_bb_u']  = $gizi['zscore_bb_u'];
            $data['zscore_tb_u']  = $gizi['zscore_tb_u'];
            $data['zscore_bb_tb'] = $gizi['zscore_bb_tb'];
            $data['keterangan']   = $gizi['keterangan'];
        }

        $this->pengukuranModel->insert($data);

        return $this->response->setJSON(['status' => true, 'message' => 'Data pengukuran berhasil ditambahkan.']);
    }

    public function show($id)
    {
        $pengukuran = $this->pengukuranModel->find($id);
        if (!$pengukuran) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON($pengukuran);
    }

    public function update($id)
    {
        $pengukuran = $this->pengukuranModel->find($id);
        if (!$pengukuran) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $rules = [
            'balita_id'          => 'required|numeric',
            'posyandu_id'        => 'required|numeric',
            'tanggal_pengukuran' => 'required|valid_date',
            'berat_badan'        => 'required|numeric',
            'tinggi_badan'       => 'required|numeric',
        ];

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

        $data = $input;

        // Hitung usia & kalkulasi otomatis
        $balita = $this->balitaModel->find($data['balita_id']);
        if ($balita) {
            $tglLahir   = new \DateTime($balita['tanggal_lahir']);
            $tglUkur    = new \DateTime($data['tanggal_pengukuran']);
            $diff       = $tglLahir->diff($tglUkur);
            $usia_bulan = ($diff->y * 12) + $diff->m;
            $data['usia_bulan'] = $usia_bulan;

            $gizi = hitung_status_gizi(
                (float)$data['berat_badan'],
                (float)$data['tinggi_badan'],
                $usia_bulan,
                $balita['jenis_kelamin']
            );
            $data['status_gizi']  = $gizi['status_gizi'];
            $data['zscore_bb_u']  = $gizi['zscore_bb_u'];
            $data['zscore_tb_u']  = $gizi['zscore_tb_u'];
            $data['zscore_bb_tb'] = $gizi['zscore_bb_tb'];
            $data['keterangan']   = $gizi['keterangan'];
        }

        $this->pengukuranModel->update($id, $data);

        return $this->response->setJSON(['status' => true, 'message' => 'Data pengukuran berhasil diupdate.']);
    }

    public function delete($id)
    {
        $pengukuran = $this->pengukuranModel->find($id);
        if (!$pengukuran) {
            return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        $this->pengukuranModel->delete($id);

        return $this->response->setJSON(['status' => true, 'message' => 'Data pengukuran berhasil dihapus.']);
    }
}

