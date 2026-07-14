<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class BeritaController extends BaseController
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $query = $this->beritaModel;

        if ($keyword) {
            $query = $query->groupStart()
                           ->like('judul', $keyword)
                           ->orLike('kategori', $keyword)
                           ->groupEnd();
        }

        $data = [
            'title'  => 'Manajemen Berita',
            'berita' => $query->orderBy('created_at', 'DESC')->paginate(10, 'berita'),
            'pager'  => $this->beritaModel->pager,
            'keyword'=> $keyword
        ];

        return view('admin/berita/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Berita'
        ];

        return view('admin/berita/create', $data);
    }

    public function store()
    {
        $rules = $this->beritaModel->getValidationRules();
        $rules['thumbnail'] = 'max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $thumbnail = $this->request->getFile('thumbnail');
        $namaThumbnail = null;

        if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
            $namaThumbnail = $thumbnail->getRandomName();
            $thumbnail->move('public/uploads/berita', $namaThumbnail);
        }

        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true);

        $data = [
            'judul'          => $judul,
            'slug'           => $slug,
            'isi'            => $this->request->getPost('isi'),
            'kategori'       => $this->request->getPost('kategori'),
            'status'         => $this->request->getPost('status'),
            'tanggal_terbit' => $this->request->getPost('status') == 'published' ? date('Y-m-d') : null,
            'thumbnail'      => $namaThumbnail,
            'penulis_id'     => session()->get('id') ?? 1
        ];

        $this->beritaModel->insert($data);

        return redirect()->to(site_url('admin/berita'))->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'  => 'Edit Berita',
            'berita' => $berita
        ];

        return view('admin/berita/edit', $data);
    }

    public function update($id)
    {
        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = $this->beritaModel->getValidationRules();
        $rules['thumbnail'] = 'max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $thumbnail = $this->request->getFile('thumbnail');
        $namaThumbnail = $berita['thumbnail'];

        if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
            if ($namaThumbnail && file_exists('public/uploads/berita/' . $namaThumbnail)) {
                unlink('public/uploads/berita/' . $namaThumbnail);
            }
            $namaThumbnail = $thumbnail->getRandomName();
            $thumbnail->move('public/uploads/berita', $namaThumbnail);
        }

        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true);
        
        $data = [
            'judul'     => $judul,
            'slug'      => $slug,
            'isi'       => $this->request->getPost('isi'),
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status'),
            'thumbnail' => $namaThumbnail
        ];
        
        if ($this->request->getPost('status') == 'published' && !$berita['tanggal_terbit']) {
            $data['tanggal_terbit'] = date('Y-m-d');
        }

        $this->beritaModel->update($id, $data);

        return redirect()->to(site_url('admin/berita'))->with('success', 'Berita berhasil diupdate.');
    }

    public function delete($id)
    {
        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($berita['thumbnail'] && file_exists('public/uploads/berita/' . $berita['thumbnail'])) {
            unlink('public/uploads/berita/' . $berita['thumbnail']);
        }

        $this->beritaModel->delete($id);

        return redirect()->to(site_url('admin/berita'))->with('success', 'Berita berhasil dihapus.');
    }
}
