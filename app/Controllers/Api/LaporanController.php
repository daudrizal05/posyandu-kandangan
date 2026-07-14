<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PosyanduModel;
use App\Models\BalitaModel;
use App\Models\PengukuranModel;
use App\Models\LansiaModel;
use App\Models\IbuHamilModel;
use App\Models\RemajaModel;
use App\Models\UsiaProduktifModel;

class LaporanController extends BaseController
{
    public function cetak_balita()
    {
        $model = new BalitaModel();
        $data['title'] = "Laporan Data Balita";
        $data['rows'] = $model->findAll();
        return view('admin/laporan/cetak', $data);
    }

    public function cetak_lansia()
    {
        $model = new LansiaModel();
        $data['title'] = "Laporan Data Lansia";
        $data['rows'] = $model->findAll();
        return view('admin/laporan/cetak', $data);
    }

    public function cetak_pengukuran()
    {
        $model = new PengukuranModel();
        $data['title'] = "Laporan Data Pengukuran Balita";
        $data['rows'] = $model->findAll();
        return view('admin/laporan/cetak', $data);
    }

    public function cetak_ibu_hamil()
    {
        $model = new IbuHamilModel();
        $data['title'] = "Laporan Data Ibu Hamil";
        $data['rows'] = $model->findAll();
        return view('admin/laporan/cetak', $data);
    }

    public function cetak_remaja()
    {
        $model = new RemajaModel();
        $data['title'] = "Laporan Data Remaja";
        $data['rows'] = $model->findAll();
        return view('admin/laporan/cetak', $data);
    }

    public function cetak_usia_produktif()
    {
        $model = new UsiaProduktifModel();
        $data['title'] = "Laporan Data Usia Produktif";
        $data['rows'] = $model->findAll();
        return view('admin/laporan/cetak', $data);
    }
}
