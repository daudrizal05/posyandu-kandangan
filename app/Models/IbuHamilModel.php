<?php

namespace App\Models;

use CodeIgniter\Model;

class IbuHamilModel extends Model
{
    protected $table            = 'ibu_hamil';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'posyandu_id',
        'nik',
        'nama_ibu',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_suami',
        'alamat',
        'no_hp',
        'tanggal_hpht',
        'taksiran_lahir',
        'golongan_darah',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getIbuHamilWithPosyandu($id = null)
    {
        $builder = $this->builder();
        $builder->select('ibu_hamil.*, posyandu.nama_posyandu');
        $builder->join('posyandu', 'posyandu.id = ibu_hamil.posyandu_id', 'left');
        
        if ($id) {
            $builder->where('ibu_hamil.id', $id);
            return $builder->get()->getRowArray();
        }
        
        return $builder->get()->getResultArray();
    }
}
