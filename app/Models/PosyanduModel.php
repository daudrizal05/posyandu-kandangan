<?php

namespace App\Models;

use CodeIgniter\Model;

class PosyanduModel extends Model
{
    protected $table            = 'posyandu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_posyandu', 'alamat', 'desa_kelurahan', 'kecamatan', 'nama_ketua_kader', 'kontak', 'latitude', 'longitude', 'foto', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama_posyandu' => 'required|max_length[150]',
        'alamat'        => 'permit_empty',
        'status'        => 'permit_empty|in_list[aktif,nonaktif]',
    ];
    protected $validationMessages = [
        'nama_posyandu' => [
            'required' => 'Nama Posyandu wajib diisi.'
        ],
        'alamat' => [
            'required' => 'Alamat wajib diisi.'
        ],
        'status' => [
            'required' => 'Status wajib dipilih.'
        ]
    ];
}
