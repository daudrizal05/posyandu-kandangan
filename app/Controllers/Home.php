<?php

namespace App\Controllers;

use App\Models\BalitaModel;
use App\Models\PosyanduModel;
use App\Models\LansiaModel;
use App\Models\PengukuranModel;

class Home extends BaseController
{
    protected $posyanduModel;
    protected $balitaModel;
    protected $LansiaModel;

    public function __construct()
    {
        $this->posyanduModel = new PosyanduModel();
        $this->balitaModel = new BalitaModel();
        $this->LansiaModel = new LansiaModel();
    }

    /** Ambil semua posyandu aktif — dipakai di setiap halaman publik */
    private function getNavData(): array
    {
        return [
            'posyanduList' => $this->posyanduModel
                ->where('status', 'aktif')
                ->orderBy('id', 'ASC')
                ->findAll(),
        ];
    }

    /** ===================== HOMEPAGE ===================== */
    public function index()
    {
        $totalBalita = $this->balitaModel->countAll();
        $balitaL = $this->balitaModel->where('jenis_kelamin', 'L')->countAllResults();
        $balitaP = $this->balitaModel->where('jenis_kelamin', 'P')->countAllResults();
        $totalPosyandu = $this->posyanduModel->where('status', 'aktif')->countAllResults();
        $totallansia = $this->LansiaModel->countAllResults();

        $data = array_merge($this->getNavData(), [
            'title' => 'SIPOSKA – Sistem Informasi Posyandu Kandangan',
            'activePage' => 'home',
            'totalBalita' => $totalBalita,
            'balitaL' => $balitaL,
            'balitaP' => $balitaP,
            'totalPosyandu' => $totalPosyandu,
            'totallansia' => $totallansia,
        ]);

        return view('home', $data);
    }

    /** ===================== DETAIL POSYANDU ===================== */
    public function posyanduDetail($id)
    {
        $posyandu = $this->posyanduModel->find($id);
        if (!$posyandu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $totalBalita = $this->balitaModel->where('posyandu_id', $id)->countAllResults();
        $balitaL = $this->balitaModel->where('posyandu_id', $id)->where('jenis_kelamin', 'L')->countAllResults();
        $balitaP = $this->balitaModel->where('posyandu_id', $id)->where('jenis_kelamin', 'P')->countAllResults();
        $lansia = $this->LansiaModel->where('posyandu_id', $id)->countAllResults();

        $data = array_merge($this->getNavData(), [
            'title' => 'Posyandu ' . $posyandu['nama_posyandu'] . ' – SIPOSKA',
            'activePage' => 'posyandu',
            'posyandu' => $posyandu,
            'totalBalita' => $totalBalita,
            'balitaL' => $balitaL,
            'balitaP' => $balitaP,
            'lansia' => $lansia,
        ]);

        return view('posyandu/detail', $data);
    }

    /** ===================== BALITA PER POSYANDU ===================== */
    public function posyanduBalita($id)
    {
        $posyandu = $this->posyanduModel->find($id);
        if (!$posyandu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $keyword = $this->request->getGet('keyword');
        $query = $this->balitaModel->where('posyandu_id', $id);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('nama_balita', $keyword)
                ->orLike('nik', $keyword)
                ->groupEnd();
        }

        $data = array_merge($this->getNavData(), [
            'title' => 'Data Balita – Posyandu ' . $posyandu['nama_posyandu'],
            'activePage' => 'posyandu',
            'posyandu' => $posyandu,
            'balita' => $query->paginate(10, 'balita'),
            'pager' => $this->balitaModel->pager,
            'keyword' => $keyword,
        ]);

        return view('posyandu/balita', $data);
    }

    /** ===================== Lansia PER POSYANDU ===================== */
    public function posyandulansia($id)
    {
        $posyandu = $this->posyanduModel->find($id);
        if (!$posyandu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $keyword = $this->request->getGet('keyword');
        $query = $this->LansiaModel->where('posyandu_id', $id);
        if ($keyword) {
            $query = $query->groupStart()
                ->like('nama', $keyword)
                ->orLike('nik', $keyword)
                ->groupEnd();
        }

        $data = array_merge($this->getNavData(), [
            'title' => 'Data Lansia – Posyandu ' . $posyandu['nama_posyandu'],
            'activePage' => 'posyandu',
            'posyandu' => $posyandu,
            'lansia' => $query->paginate(10, 'lansia'),
            'pager' => $this->LansiaModel->pager,
            'keyword' => $keyword,
        ]);

        return view('posyandu/lansia', $data);
    }

    /** ===================== BERITA (LIST) ===================== */
    public function berita()
    {
        $beritaModel = new \App\Models\BeritaModel();
        $keyword = $this->request->getGet('keyword');
        $query = $beritaModel->where('status', 'published');
        if ($keyword) {
            $query = $query->groupStart()->like('judul', $keyword)->orLike('kategori', $keyword)->groupEnd();
        }

        $data = array_merge($this->getNavData(), [
            'title' => 'Berita – SIPOSKA',
            'activePage' => 'berita',
            'berita' => $query->orderBy('tanggal_terbit', 'DESC')->paginate(9, 'berita'),
            'pager' => $beritaModel->pager,
            'keyword' => $keyword,
        ]);
        return view('publik/berita/index', $data);
    }

    /** ===================== BERITA (DETAIL) ===================== */
    public function beritaDetail($slug)
    {
        $beritaModel = new \App\Models\BeritaModel();
        $berita = $beritaModel->where('slug', $slug)->where('status', 'published')->first();
        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // Increment views
        $beritaModel->update($berita['id'], ['views' => ($berita['views'] ?? 0) + 1]);

        $related = $beritaModel->where('status', 'published')
            ->where('id !=', $berita['id'])
            ->orderBy('tanggal_terbit', 'DESC')
            ->limit(3)
            ->findAll();

        $data = array_merge($this->getNavData(), [
            'title' => esc($berita['judul']) . ' – SIPOSKA',
            'activePage' => 'berita',
            'berita' => $berita,
            'related' => $related,
        ]);
        return view('publik/berita/detail', $data);
    }

    /** ===================== GALERI ===================== */
    public function galeri()
    {
        $galeriModel = new \App\Models\GaleriModel();
        $data = array_merge($this->getNavData(), [
            'title' => 'Galeri – SIPOSKA',
            'activePage' => 'galeri',
            'galeri' => $galeriModel->orderBy('created_at', 'DESC')->paginate(12, 'galeri'),
            'pager' => $galeriModel->pager,
        ]);
        return view('publik/galeri/index', $data);
    }
    /** ===================== HALAMAN STATIS / PROFIL ===================== */
    public function profil()
    {
        return $this->halaman('tentang-kami');
    }

    public function halaman($slug)
    {
        $halamanModel = new \App\Models\HalamanStatisModel();
        $halaman = $halamanModel->where('slug', $slug)->first();

        // Jika data tidak ada di db, tampilkan pesan fallback
        if (!$halaman) {
            $halaman = [
                'judul' => ucwords(str_replace('-', ' ', $slug)),
                'konten' => '<div style="padding:40px 0; text-align:center; color:#64748b;">
                                <i class="fas fa-file-alt" style="font-size:48px; margin-bottom:15px; opacity:0.5;"></i>
                                <p>Halaman belum tersedia atau konten sedang diperbarui.</p>
                             </div>',
                'slug' => $slug
            ];
        }

        $data = array_merge($this->getNavData(), [
            'title' => esc($halaman['judul']) . ' – SIPOSKA',
            'activePage' => 'profil',
            'halaman' => $halaman,
        ]);
        return view('publik/halaman/detail', $data);
    }
}


