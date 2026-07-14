<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\IbuHamilModel;
use App\Models\PosyanduModel;
use App\Models\IbuHamilAnakModel;

class IbuHamilController extends BaseController
{
    protected $ibuHamilModel;
    protected $posyanduModel;
    protected $anakModel;

    public function __construct()
    {
        $this->ibuHamilModel = new IbuHamilModel();
        $this->posyanduModel = new PosyanduModel();
        $this->anakModel     = new IbuHamilAnakModel();
        helper('StatusGizi');
    }

    public function index()
    {
        $keyword     = $this->request->getGet('keyword');
        $posyandu_id = $this->request->getGet('posyandu_id');
        $status      = $this->request->getGet('status');

        $query = $this->ibuHamilModel
            ->select('ibu_hamil.*, posyandu.nama_posyandu')
            ->join('posyandu', 'posyandu.id = ibu_hamil.posyandu_id', 'left');

        if ($keyword) {
            $query = $query->groupStart()
                           ->like('ibu_hamil.nik', $keyword)
                           ->orLike('ibu_hamil.nama_ibu', $keyword)
                           ->groupEnd();
        }

        if ($posyandu_id) {
            $query = $query->where('ibu_hamil.posyandu_id', $posyandu_id);
        }

        if ($status) {
            $query = $query->where('ibu_hamil.status', $status);
        }
        
        $ibuHamilList = $query->paginate(10, 'ibu_hamil');
        
        // Inject jumlah anak per ibu hamil
        foreach ($ibuHamilList as &$ibu) {
            $ibu['jumlah_anak'] = $this->anakModel->where('ibu_hamil_id', $ibu['id'])->countAllResults();
        }

        $data = [
            'title'       => 'Data Ibu Hamil',
            'ibu_hamil'   => $ibuHamilList,
            'pager'       => $this->ibuHamilModel->pager,
            'posyandu'    => $this->posyanduModel->orderBy('id', 'ASC')->findAll(),
            'keyword'     => $keyword,
            'posyandu_id' => $posyandu_id,
            'status'      => $status,
        ];

        return view('admin/ibu_hamil/index', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Data Ibu Hamil',
            'posyandu' => $this->posyanduModel->orderBy('id', 'ASC')->findAll(),
        ];

        return view('admin/ibu_hamil/create', $data);
    }

    public function store()
    {
        $rules = $this->ibuHamilModel->getValidationRules();

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Insert Induk
        $dataIbu = $this->request->getPost();
        // Hapus array anak dari data induk jika ada agar tidak error mass assignment
        unset($dataIbu['anak']); 
        
        $this->ibuHamilModel->insert($dataIbu);
        $ibuHamilId = $this->ibuHamilModel->getInsertID();

        // 2. Insert Anak
        $anakList = $this->request->getPost('anak') ?? [];
        foreach ($anakList as $anak) {
            if (!empty($anak['nama_anak']) && !empty($anak['tanggal_lahir'])) {
                // Hitung Z-Score via Helper
                $umurBulan = hitung_umur_bulan($anak['tanggal_lahir']);
                $hasilGizi = hitung_status_gizi_detail($anak['berat'], $anak['tinggi'], $umurBulan, $anak['jenis_kelamin']);

                $this->anakModel->insert([
                    'ibu_hamil_id'  => $ibuHamilId,
                    'nama_anak'     => $anak['nama_anak'],
                    'jenis_kelamin' => $anak['jenis_kelamin'],
                    'tanggal_lahir' => $anak['tanggal_lahir'],
                    'nama_ortu'     => $anak['nama_ortu'],
                    'posyandu_id'   => $anak['posyandu_id'],
                    'berat'         => $anak['berat'],
                    'tinggi'        => $anak['tinggi'],
                    'bb_u'          => $hasilGizi['bb_u']['status'],
                    'zs_bb_u'       => $hasilGizi['bb_u']['zscore'],
                    'tb_u'          => $hasilGizi['tb_u']['status'],
                    'zs_tb_u'       => $hasilGizi['tb_u']['zscore'],
                    'bb_tb'         => $hasilGizi['bb_tb']['status'],
                    'zs_bb_tb'      => $hasilGizi['bb_tb']['zscore'],
                ]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }

        return redirect()->to(site_url('admin/ibu_hamil'))->with('success', 'Data ibu hamil berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ibu = $this->ibuHamilModel->find($id);
        if (!$ibu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'    => 'Edit Data Ibu Hamil',
            'ibu'      => $ibu,
            'posyandu' => $this->posyanduModel->orderBy('id', 'ASC')->findAll(),
            'anak'     => $this->anakModel->where('ibu_hamil_id', $id)->findAll(),
        ];

        return view('admin/ibu_hamil/edit', $data);
    }

    public function update($id)
    {
        $ibu = $this->ibuHamilModel->find($id);
        if (!$ibu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = $this->ibuHamilModel->getValidationRules();
        // Fix unique rule for update — exclude current record
        $rules['nik'] = 'required|max_length[16]|is_unique[ibu_hamil.nik,id,' . $id . ']';
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Update Induk
        $dataIbu = $this->request->getPost();
        unset($dataIbu['anak']);
        $this->ibuHamilModel->update($id, $dataIbu);

        // 2. Sync Anak
        $anakList = $this->request->getPost('anak') ?? [];
        $existingAnakIds = [];

        foreach ($anakList as $anak) {
            if (!empty($anak['nama_anak']) && !empty($anak['tanggal_lahir'])) {
                $umurBulan = hitung_umur_bulan($anak['tanggal_lahir']);
                $hasilGizi = hitung_status_gizi_detail($anak['berat'], $anak['tinggi'], $umurBulan, $anak['jenis_kelamin']);
                
                $dataAnak = [
                    'ibu_hamil_id'  => $id,
                    'nama_anak'     => $anak['nama_anak'],
                    'jenis_kelamin' => $anak['jenis_kelamin'],
                    'tanggal_lahir' => $anak['tanggal_lahir'],
                    'nama_ortu'     => $anak['nama_ortu'],
                    'posyandu_id'   => $anak['posyandu_id'],
                    'berat'         => $anak['berat'],
                    'tinggi'        => $anak['tinggi'],
                    'bb_u'          => $hasilGizi['bb_u']['status'],
                    'zs_bb_u'       => $hasilGizi['bb_u']['zscore'],
                    'tb_u'          => $hasilGizi['tb_u']['status'],
                    'zs_tb_u'       => $hasilGizi['tb_u']['zscore'],
                    'bb_tb'         => $hasilGizi['bb_tb']['status'],
                    'zs_bb_tb'      => $hasilGizi['bb_tb']['zscore'],
                ];

                if (!empty($anak['id'])) {
                    // Update
                    $this->anakModel->update($anak['id'], $dataAnak);
                    $existingAnakIds[] = $anak['id'];
                } else {
                    // Insert
                    $this->anakModel->insert($dataAnak);
                    $existingAnakIds[] = $this->anakModel->getInsertID();
                }
            }
        }

        // Delete anak yang dihapus di frontend
        if (!empty($existingAnakIds)) {
            $this->anakModel->where('ibu_hamil_id', $id)
                            ->whereNotIn('id', $existingAnakIds)
                            ->delete();
        } else {
            // Hapus semua jika array kosong (semua baris dihapus)
            $this->anakModel->where('ibu_hamil_id', $id)->delete();
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengupdate data.');
        }

        return redirect()->to(site_url('admin/ibu_hamil'))->with('success', 'Data ibu hamil berhasil diupdate.');
    }

    public function delete($id)
    {
        $ibu = $this->ibuHamilModel->find($id);
        if (!$ibu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // $this->anakModel is cascaded from DB, but we do it anyway for clarity
        $this->anakModel->where('ibu_hamil_id', $id)->delete();
        $this->ibuHamilModel->delete($id);

        return redirect()->to(site_url('admin/ibu_hamil'))->with('success', 'Data ibu hamil berhasil dihapus.');
    }

    /**
     * Endpoint untuk perhitungan Z-Score dinamis via AJAX
     */
    public function hitung_zscore()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Invalid request']);
        }

        $berat = $this->request->getPost('berat');
        $tinggi = $this->request->getPost('tinggi');
        $tgl_lahir = $this->request->getPost('tgl_lahir');
        $jk = $this->request->getPost('jk');

        if (empty($berat) || empty($tinggi) || empty($tgl_lahir) || empty($jk)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lengkapi Berat, Tinggi, Tgl Lahir, dan Jenis Kelamin'
            ]);
        }

        $umurBulan = hitung_umur_bulan($tgl_lahir);
        $hasil = hitung_status_gizi_detail($berat, $tinggi, $umurBulan, $jk);

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'bb_u_status' => $hasil['bb_u']['status'],
                'bb_u_zscore' => $hasil['bb_u']['zscore'],
                'tb_u_status' => $hasil['tb_u']['status'],
                'tb_u_zscore' => $hasil['tb_u']['zscore'],
                'bb_tb_status' => $hasil['bb_tb']['status'],
                'bb_tb_zscore' => $hasil['bb_tb']['zscore']
            ]
        ]);
    }
}
