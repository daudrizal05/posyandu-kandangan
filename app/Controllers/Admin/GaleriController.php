<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GaleriModel;

class GaleriController extends BaseController
{
    protected $galeriModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Galeri',
            'galeri' => $this->galeriModel->orderBy('tanggal', 'DESC')->paginate(10, 'galeri'),
            'pager'  => $this->galeriModel->pager
        ];

        return view('admin/galeri/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Galeri'
        ];

        return view('admin/galeri/create', $data);
    }

    public function store()
    {
        $rules = $this->galeriModel->getValidationRules();
        $rules['foto'] = 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = $foto->getRandomName();
        $foto->move('public/uploads/galeri', $namaFoto);

        $data = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal'   => $this->request->getPost('tanggal'),
            'foto'      => $namaFoto,
            'user_id'   => session()->get('id') ?? 1
        ];

        $this->galeriModel->insert($data);

        return redirect()->to(site_url('admin/galeri'))->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'  => 'Edit Galeri',
            'galeri' => $galeri
        ];

        return view('admin/galeri/edit', $data);
    }

    public function update($id)
    {
        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = $this->galeriModel->getValidationRules();
        $rules['foto'] = 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = $galeri['foto'];

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if ($namaFoto && file_exists('public/uploads/galeri/' . $namaFoto)) {
                unlink('public/uploads/galeri/' . $namaFoto);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move('public/uploads/galeri', $namaFoto);
        }
        
        $data = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal'   => $this->request->getPost('tanggal'),
            'foto'      => $namaFoto
        ];

        $this->galeriModel->update($id, $data);

        return redirect()->to(site_url('admin/galeri'))->with('success', 'Galeri berhasil diupdate.');
    }

    public function delete($id)
    {
        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($galeri['foto'] && file_exists('public/uploads/galeri/' . $galeri['foto'])) {
            unlink('public/uploads/galeri/' . $galeri['foto']);
        }

        $this->galeriModel->delete($id);

        return redirect()->to(site_url('admin/galeri'))->with('success', 'Galeri berhasil dihapus.');
    }
}
