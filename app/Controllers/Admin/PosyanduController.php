<?php

namespace App\Controllers\Admin;

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
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');

        $query = $this->posyanduModel;

        if ($keyword) {
            $query = $query->groupStart()
                           ->like('nama_posyandu', $keyword)
                           ->orLike('kecamatan', $keyword)
                           ->groupEnd();
        }

        if ($status) {
            $query = $query->where('status', $status);
        }

        $data = [
            'title'    => 'Manajemen Posyandu',
            'posyandu' => $query->orderBy('id', 'ASC')->paginate(10, 'posyandu'),
            'pager'    => $this->posyanduModel->pager,
            'keyword'  => $keyword,
            'status'   => $status
        ];

        return view('admin/posyandu/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Posyandu'
        ];

        return view('admin/posyandu/create', $data);
    }

    public function store()
    {
        // Validation is defined in the model, but we need to validate file separately or trigger model validation
        $rules = $this->posyanduModel->getValidationRules();
        $rules['foto'] = 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]';

        if (!$this->validate($rules, $this->posyanduModel->getValidationMessages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle File Upload
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('public/uploads/posyandu', $namaFoto);
        }

        $data = [
            'nama_posyandu'    => $this->request->getPost('nama_posyandu'),
            'alamat'           => $this->request->getPost('alamat'),
            'desa_kelurahan'   => $this->request->getPost('desa_kelurahan'),
            'kecamatan'        => $this->request->getPost('kecamatan'),
            'nama_ketua_kader' => $this->request->getPost('nama_ketua_kader'),
            'kontak'           => $this->request->getPost('kontak'),
            'latitude'         => $this->request->getPost('latitude'),
            'longitude'        => $this->request->getPost('longitude'),
            'status'           => $this->request->getPost('status') ?? 'aktif',
            'foto'             => $namaFoto
        ];

        $this->posyanduModel->insert($data);

        return redirect()->to(site_url('admin/posyandu'))->with('success', 'Data posyandu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $posyandu = $this->posyanduModel->find($id);
        if (!$posyandu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'    => 'Edit Posyandu',
            'posyandu' => $posyandu
        ];

        return view('admin/posyandu/edit', $data);
    }

    public function update($id)
    {
        $posyandu = $this->posyanduModel->find($id);
        if (!$posyandu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = $this->posyanduModel->getValidationRules();
        $rules['foto'] = 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]';

        if (!$this->validate($rules, $this->posyanduModel->getValidationMessages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle File Upload
        $foto = $this->request->getFile('foto');
        $namaFoto = $posyandu['foto'];

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Delete old file if exists
            if ($namaFoto && file_exists('public/uploads/posyandu/' . $namaFoto)) {
                unlink('public/uploads/posyandu/' . $namaFoto);
            }

            $namaFoto = $foto->getRandomName();
            $foto->move('public/uploads/posyandu', $namaFoto);
        }

        $data = [
            'nama_posyandu'    => $this->request->getPost('nama_posyandu'),
            'alamat'           => $this->request->getPost('alamat'),
            'desa_kelurahan'   => $this->request->getPost('desa_kelurahan'),
            'kecamatan'        => $this->request->getPost('kecamatan'),
            'nama_ketua_kader' => $this->request->getPost('nama_ketua_kader'),
            'kontak'           => $this->request->getPost('kontak'),
            'latitude'         => $this->request->getPost('latitude'),
            'longitude'        => $this->request->getPost('longitude'),
            'status'           => $this->request->getPost('status'),
            'foto'             => $namaFoto
        ];

        $this->posyanduModel->update($id, $data);

        return redirect()->to(site_url('admin/posyandu'))->with('success', 'Data posyandu berhasil diupdate.');
    }

    public function delete($id)
    {
        $posyandu = $this->posyanduModel->find($id);
        if (!$posyandu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($posyandu['foto'] && file_exists('public/uploads/posyandu/' . $posyandu['foto'])) {
            unlink('public/uploads/posyandu/' . $posyandu['foto']);
        }

        $this->posyanduModel->delete($id);

        return redirect()->to(site_url('admin/posyandu'))->with('success', 'Data posyandu berhasil dihapus.');
    }
}
