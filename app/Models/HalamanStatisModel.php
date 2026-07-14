<?php

namespace App\Models;

use CodeIgniter\Model;

class HalamanStatisModel extends Model
{
    protected $table            = 'halaman_statis';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['slug', 'judul', 'konten'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
