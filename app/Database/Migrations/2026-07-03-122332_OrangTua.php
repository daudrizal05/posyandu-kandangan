<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrangTua extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'nama_ayah'      => ['type' => 'VARCHAR', 'constraint' => '100'],
            'nama_ibu'       => ['type' => 'VARCHAR', 'constraint' => '100'],
            'nik_ibu'        => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'no_hp'          => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'alamat'         => ['type' => 'TEXT'],
            'posyandu_id'    => ['type' => 'BIGINT', 'unsigned' => true],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('orang_tua');
    }

    public function down()
    {
        $this->forge->dropTable('orang_tua');
    }
}