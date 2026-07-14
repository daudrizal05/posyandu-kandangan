<?php

namespace App\Models;

use CodeIgniter\Model;

class BalitaModel extends Model
{
    protected $table            = 'balita';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'posyandu_id', 'nik', 'nama_balita', 'jenis_kelamin', 'tempat_lahir',
        'tanggal_lahir', 'nama_ayah', 'nama_ibu', 'alamat', 'berat_lahir',
        'tinggi_lahir', 'status', 'berat', 'tinggi', 'bb_u', 'zs_bb_u', 
        'tb_u', 'zs_tb_u', 'bb_tb', 'zs_bb_tb'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'posyandu_id'   => 'required|numeric',
        'nik'           => 'required|max_length[16]|is_unique[balita.nik,id,{id}]',
        'nama_balita'   => 'required|max_length[100]',
        'tanggal_lahir' => 'required|valid_date',
        'jenis_kelamin' => 'required|in_list[L,P]'
    ];
}
