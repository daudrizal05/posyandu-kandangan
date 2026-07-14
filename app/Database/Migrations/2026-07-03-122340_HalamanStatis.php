<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HalamanStatis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'slug'           => ['type' => 'VARCHAR', 'constraint' => '255', 'unique' => true],
            'judul'          => ['type' => 'VARCHAR', 'constraint' => '255'],
            'konten'         => ['type' => 'TEXT'],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('halaman_statis');
    }

    public function down()
    {
        $this->forge->dropTable('halaman_statis');
    }
}