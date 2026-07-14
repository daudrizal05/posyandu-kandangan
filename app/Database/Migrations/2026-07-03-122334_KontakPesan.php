<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KontakPesan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'nama'           => ['type' => 'VARCHAR', 'constraint' => '100'],
            'email'          => ['type' => 'VARCHAR', 'constraint' => '100'],
            'subjek'         => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'pesan'          => ['type' => 'TEXT'],
            'status_baca'    => ['type' => 'BOOLEAN', 'default' => false],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kontak_pesan');
    }

    public function down()
    {
        $this->forge->dropTable('kontak_pesan');
    }
}