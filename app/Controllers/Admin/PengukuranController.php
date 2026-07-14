<?php

namespace App\Controllers\Admin;

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
        $keyword = $this->request->getGet('keyword');
        $posyandu_id = $this->request->getGet('posyandu_id');
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $query = $this->pengukuranModel->select('pengukuran.*, balita.nama_balita, balita.nik, posyandu.nama_posyandu')
                                       ->join('balita', 'balita.id = pengukuran.balita_id')
                                       ->join('posyandu', 'posyandu.id = pengukuran.posyandu_id');

        if ($keyword) {
            $query = $query->groupStart()
                           ->like('balita.nama_balita', $keyword)
                           ->orLike('balita.nik', $keyword)
                           ->groupEnd();
        }

        if ($posyandu_id) {
            $query = $query->where('pengukuran.posyandu_id', $posyandu_id);
        }

        if ($bulan && $tahun) {
            $query = $query->where('EXTRACT(MONTH FROM tanggal_pengukuran) =', $bulan)
                           ->where('EXTRACT(YEAR FROM tanggal_pengukuran) =', $tahun);
        }

        $data = [
            'title'      => 'Data Pengukuran Balita',
            'pengukuran' => $query->orderBy('tanggal_pengukuran', 'DESC')->paginate(10, 'pengukuran'),
            'pager'      => $this->pengukuranModel->pager,
            'posyandu'   => $this->posyanduModel->orderBy('id', 'ASC')->findAll(),
            'keyword'    => $keyword,
            'posyandu_id'=> $posyandu_id,
            'bulan'      => $bulan,
            'tahun'      => $tahun
        ];

        return view('admin/pengukuran/index', $data);
    }

    public function create()
    {
        // Ambil 10 data pengukuran terakhir untuk ditampilkan di sub tabel
        $recentPengukuran = $this->pengukuranModel
            ->select('pengukuran.*, balita.nama_balita, balita.nik, balita.jenis_kelamin, balita.tanggal_lahir, balita.nama_ibu, balita.nama_ayah, posyandu.nama_posyandu')
            ->join('balita', 'balita.id = pengukuran.balita_id')
            ->join('posyandu', 'posyandu.id = pengukuran.posyandu_id')
            ->orderBy('pengukuran.created_at', 'DESC')
            ->limit(10)
            ->findAll();

        $data = [
            'title'    => 'Tambah Pengukuran',
            'posyandu' => $this->posyanduModel->orderBy('id', 'ASC')->findAll(),
            'balita'   => $this->balitaModel->where('status', 'aktif')->findAll(),
            'recent'   => $recentPengukuran
        ];

        return view('admin/pengukuran/create', $data);
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

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

        return redirect()->to(site_url('admin/pengukuran'))->with('success', 'Data pengukuran berhasil ditambahkan. Status gizi: ' . label_status_gizi($data['status_gizi'] ?? 'normal'));
    }

    public function edit($id)
    {
        $pengukuran = $this->pengukuranModel->find($id);
        if (!$pengukuran) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil riwayat pengukuran balita ini
        $recentPengukuran = $this->pengukuranModel
            ->select('pengukuran.*, balita.nama_balita, balita.nik, balita.jenis_kelamin, balita.tanggal_lahir, balita.nama_ibu, balita.nama_ayah, posyandu.nama_posyandu')
            ->join('balita', 'balita.id = pengukuran.balita_id')
            ->join('posyandu', 'posyandu.id = pengukuran.posyandu_id')
            ->where('pengukuran.balita_id', $pengukuran['balita_id'])
            ->orderBy('pengukuran.tanggal_pengukuran', 'DESC')
            ->limit(10)
            ->findAll();

        $data = [
            'title'      => 'Edit Pengukuran',
            'pengukuran' => $pengukuran,
            'posyandu'   => $this->posyanduModel->orderBy('id', 'ASC')->findAll(),
            'balita'     => $this->balitaModel->where('status', 'aktif')->findAll(),
            'recent'     => $recentPengukuran
        ];

        return view('admin/pengukuran/edit', $data);
    }

    public function update($id)
    {
        $pengukuran = $this->pengukuranModel->find($id);
        if (!$pengukuran) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'balita_id'          => 'required|numeric',
            'posyandu_id'        => 'required|numeric',
            'tanggal_pengukuran' => 'required|valid_date',
            'berat_badan'        => 'required|numeric',
            'tinggi_badan'       => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

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

        return redirect()->to(site_url('admin/pengukuran'))->with('success', 'Data pengukuran berhasil diupdate. Status gizi: ' . label_status_gizi($data['status_gizi'] ?? 'normal'));
    }

    public function delete($id)
    {
        $pengukuran = $this->pengukuranModel->find($id);
        if (!$pengukuran) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->pengukuranModel->delete($id);

        return redirect()->to(site_url('admin/pengukuran'))->with('success', 'Data pengukuran berhasil dihapus.');
    }
}
