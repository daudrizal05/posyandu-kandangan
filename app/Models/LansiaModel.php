<?php

namespace App\Models;

use CodeIgniter\Model;

class LansiaModel extends Model
{
    protected $table = 'lansia';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'posyandu_id', 'nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'alamat', 
        'no_hp', 'status_pernikahan', 'kondisi_kesehatan', 'riwayat_penyakit',
        'umur', 'lingkar_lengan_atas', 'bb', 'tb', 'lingkar_pinggang', 'imt', 
        'no_bpjs', 'keluhan', 'tensi', 'obat'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
    'nik'         => 'required|max_length[16]|is_unique[lansia.nik,id,{id}]',
    'nama'        => 'required|max_length[100]',
    'alamat'      => 'required',
    'tanggal_lahir' => 'required',
    'umur'        => 'required|numeric',
    'lingkar_lengan_atas' => 'required|numeric',
    'bb'          => 'required|numeric',
    'tb'          => 'required|numeric',
    'lingkar_pinggang' => 'required|numeric',
    'imt'         => 'required|numeric',
    'no_bpjs'     => 'required|max_length[50]',
    'keluhan'     => 'required',
    'tensi'       => 'required|max_length[20]',
    'obat'        => 'required'
];

    protected $validationMessages = [
        'nik' => [
            'is_unique' => 'NIK sudah terdaftar.',
        ],
    ];
}

