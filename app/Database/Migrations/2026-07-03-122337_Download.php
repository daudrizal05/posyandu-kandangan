<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Download extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'judul_file'     => ['type' => 'VARCHAR', 'constraint' => '255'],
            'file'           => ['type' => 'VARCHAR', 'constraint' => '255'],
            'kategori'       => ['type' => 'VARCHAR', 'constraint' => '50'],
            'tanggal_upload' => ['type' => 'DATE', 'null' => true],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('download');
    }

    public function down()
    {
        $this->forge->dropTable('download');
    }
}