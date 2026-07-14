<?php

namespace App\Models;

use CodeIgniter\Model;

class IbuHamilAnakModel extends Model
{
    protected $table            = 'ibu_hamil_anak';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ibu_hamil_id', 'nama_anak', 'jenis_kelamin', 'tanggal_lahir', 
        'nama_ortu', 'posyandu_id', 'berat', 'tinggi', 
        'bb_u', 'zs_bb_u', 'tb_u', 'zs_tb_u', 'bb_tb', 'zs_bb_tb'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
