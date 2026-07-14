<?php

namespace App\Models;

use CodeIgniter\Model;

class RemajaModel extends Model
{
    protected $table            = 'remaja';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'posyandu_id', 'nik', 'nama', 'tanggal_lahir', 'jenis_kelamin',
        'alamat', 'no_hp', 'berat_badan', 'tinggi_badan', 'lila',
        'tekanan_darah', 'hb'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRemajaWithPosyandu($id = null)
    {
        $builder = $this->builder();
        $builder->select('remaja.*, posyandu.nama_posyandu');
        $builder->join('posyandu', 'posyandu.id = remaja.posyandu_id', 'left');
        
        if ($id) {
            $builder->where('remaja.id', $id);
            return $builder->get()->getRowArray();
        }
        
        return $builder->get()->getResultArray();
    }
}
