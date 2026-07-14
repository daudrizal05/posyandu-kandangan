<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Berita extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'judul'          => ['type' => 'VARCHAR', 'constraint' => '255'],
            'slug'           => ['type' => 'VARCHAR', 'constraint' => '255', 'unique' => true],
            'thumbnail'      => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'isi'            => ['type' => 'TEXT'],
            'kategori'       => ['type' => 'VARCHAR', 'constraint' => '100'],
            'penulis_id'     => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'tanggal_terbit' => ['type' => 'DATE', 'null' => true],
            'status'         => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'draft'],
            'views'          => ['type' => 'INT', 'default' => 0],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('penulis_id', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita');
    }
}