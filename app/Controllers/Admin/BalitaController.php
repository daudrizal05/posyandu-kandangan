<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BalitaModel;
use App\Models\PosyanduModel;

class BalitaController extends BaseController
{
    protected $balitaModel;
    protected $posyanduModel;

    public function __construct()
    {
        $this->balitaModel = new BalitaModel();
        $this->posyanduModel = new PosyanduModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $posyandu_id = $this->request->getGet('posyandu_id');

        $query = $this->balitaModel->select('balita.*, posyandu.nama_posyandu')
                                   ->join('posyandu', 'posyandu.id = balita.posyandu_id', 'left');

        if ($keyword) {
            $query = $query->groupStart()
                           ->like('balita.nik', $keyword)
                           ->orLike('balita.nama_balita', $keyword)
                           ->groupEnd();
        }

        if ($posyandu_id) {
            $query = $query->where('balita.posyandu_id', $posyandu_id);
        }

        $data = [
            'title'    => 'Data Balita',
            'balita'   => $query->paginate(10, 'balita'),
            'pager'    => $this->balitaModel->pager,
            'posyandu' => $this->posyanduModel->orderBy('id', 'ASC')->findAll(),
            'keyword'  => $keyword,
            'posyandu_id' => $posyandu_id
        ];

        return view('admin/balita/index', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Data Balita',
            'posyandu' => $this->posyanduModel->orderBy('id', 'ASC')->findAll()
        ];

        return view('admin/balita/create', $data);
    }

    public function store()
    {
        $rules = $this->balitaModel->getValidationRules();

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->balitaModel->insert($this->request->getPost());

        return redirect()->to(site_url('admin/balita'))->with('success', 'Data balita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $balita = $this->balitaModel->find($id);
        if (!$balita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'    => 'Edit Data Balita',
            'balita'   => $balita,
            'posyandu' => $this->posyanduModel->orderBy('id', 'ASC')->findAll()
        ];

        return view('admin/balita/edit', $data);
    }

    public function update($id)
    {
        $balita = $this->balitaModel->find($id);
        if (!$balita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = $this->balitaModel->getValidationRules();
        // Fix unique rule for update — exclude current record
        $rules['nik'] = 'required|max_length[16]|is_unique[balita.nik,id,' . $id . ']';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->balitaModel->update($id, $this->request->getPost());

        return redirect()->to(site_url('admin/balita'))->with('success', 'Data balita berhasil diupdate.');
    }

    public function delete($id)
    {
        $balita = $this->balitaModel->find($id);
        if (!$balita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->balitaModel->delete($id);

        return redirect()->to(site_url('admin/balita'))->with('success', 'Data balita berhasil dihapus.');
    }
}
