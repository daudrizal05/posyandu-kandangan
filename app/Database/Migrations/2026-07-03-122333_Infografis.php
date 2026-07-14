<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Infografis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'judul'          => ['type' => 'VARCHAR', 'constraint' => '255'],
            'deskripsi'      => ['type' => 'TEXT', 'null' => true],
            'foto'           => ['type' => 'VARCHAR', 'constraint' => '255'],
            'tanggal_upload' => ['type' => 'DATE', 'null' => true],
            'views'          => ['type' => 'INT', 'default' => 0],
            'user_id'        => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('infografis');
    }

    public function down()
    {
        $this->forge->dropTable('infografis');
    }
}