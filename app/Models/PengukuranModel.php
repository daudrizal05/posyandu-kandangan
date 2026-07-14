<?php

namespace App\Models;

use CodeIgniter\Model;

class PengukuranModel extends Model
{
    protected $table            = 'pengukuran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'balita_id', 'posyandu_id', 'tanggal_pengukuran', 'usia_bulan',
        'berat_badan', 'tinggi_badan', 'lingkar_kepala', 'lila',
        'zscore_bb_u', 'zscore_tb_u', 'zscore_bb_tb', 'status_gizi',
        'keterangan', 'petugas_id'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'balita_id'          => 'required|numeric',
        'posyandu_id'        => 'required|numeric',
        'tanggal_pengukuran' => 'required|valid_date',
        'berat_badan'        => 'required|numeric',
        'tinggi_badan'       => 'required|numeric',
        'status_gizi'        => 'required|in_list[normal,kurang,stunting,gizi_buruk]'
    ];
}
