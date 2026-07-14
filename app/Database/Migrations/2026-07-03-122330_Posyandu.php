<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posyandu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'nama_posyandu'    => ['type' => 'VARCHAR', 'constraint' => '150'],
            'alamat'           => ['type' => 'TEXT'],
            'desa_kelurahan'   => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'kecamatan'        => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'nama_ketua_kader' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'kontak'           => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'latitude'         => ['type' => 'DECIMAL', 'constraint' => '10,8', 'null' => true],
            'longitude'        => ['type' => 'DECIMAL', 'constraint' => '11,8', 'null' => true],
            'foto'             => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'status'           => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'aktif'],
            'created_at'       => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'       => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('posyandu');
    }

    public function down()
    {
        $this->forge->dropTable('posyandu');
    }
}