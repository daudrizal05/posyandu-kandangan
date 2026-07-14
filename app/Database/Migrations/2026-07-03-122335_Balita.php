<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Balita extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                  => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'posyandu_id'         => ['type' => 'BIGINT', 'unsigned' => true],
            'nik'                 => ['type' => 'VARCHAR', 'constraint' => '16', 'unique' => true],
            'nama_balita'         => ['type' => 'VARCHAR', 'constraint' => '100'],
            'jenis_kelamin'       => ['type' => 'VARCHAR', 'constraint' => '10'],
            'tempat_lahir'        => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'tanggal_lahir'       => ['type' => 'DATE'],
            'nama_ayah'           => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'nama_ibu'            => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'alamat'              => ['type' => 'TEXT', 'null' => true],
            'berat_lahir'         => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'tinggi_lahir'        => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'status'              => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'aktif'],
            'created_at'          => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'          => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('balita');
    }

    public function down()
    {
        $this->forge->dropTable('balita');
    }
}