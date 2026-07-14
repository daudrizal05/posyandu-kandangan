<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_posyandu' => 'Posyandu Ploso Rejo', 'alamat' => 'Dusun Ploso Rejo', 'desa_kelurahan' => 'Kandangan', 'kecamatan' => 'Kandangan', 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Tengger', 'alamat' => 'Dusun Tengger', 'desa_kelurahan' => 'Kandangan', 'kecamatan' => 'Kandangan', 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Desan', 'alamat' => 'Dusun Desan', 'desa_kelurahan' => 'Kandangan', 'kecamatan' => 'Kandangan', 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Kandangan I', 'alamat' => 'Dusun Kandangan I', 'desa_kelurahan' => 'Kandangan', 'kecamatan' => 'Kandangan', 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Kandangan II', 'alamat' => 'Dusun Kandangan II', 'desa_kelurahan' => 'Kandangan', 'kecamatan' => 'Kandangan', 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Karang Tejo', 'alamat' => 'Dusun Karang Tejo', 'desa_kelurahan' => 'Kandangan', 'kecamatan' => 'Kandangan', 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Sidomulyo I', 'alamat' => 'Dusun Sidomulyo I', 'desa_kelurahan' => 'Kandangan', 'kecamatan' => 'Kandangan', 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Sidomulyo II', 'alamat' => 'Dusun Sidomulyo II', 'desa_kelurahan' => 'Kandangan', 'kecamatan' => 'Kandangan', 'status' => 'aktif'],
        ];

        foreach ($data as $row) {
            $row['created_at'] = date('Y-m-d H:i:s');
            $row['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('posyandu')->insert($row);
        }
    }
}