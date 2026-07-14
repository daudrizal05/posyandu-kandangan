<?php

namespace App\Models;

use CodeIgniter\Model;

class UsiaProduktifModel extends Model
{
    protected $table            = 'usia_produktif';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'posyandu_id', 'nik', 'nama', 'tanggal_lahir', 'jenis_kelamin',
        'alamat', 'no_hp', 'berat_badan', 'tinggi_badan', 'lingkar_perut',
        'tekanan_darah', 'gula_darah', 'kolesterol', 'asam_urat'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUsiaProduktifWithPosyandu($id = null)
    {
        $builder = $this->builder();
        $builder->select('usia_produktif.*, posyandu.nama_posyandu');
        $builder->join('posyandu', 'posyandu.id = usia_produktif.posyandu_id', 'left');
        
        if ($id) {
            $builder->where('usia_produktif.id', $id);
            return $builder->get()->getRowArray();
        }
        
        return $builder->get()->getResultArray();
    }
}
