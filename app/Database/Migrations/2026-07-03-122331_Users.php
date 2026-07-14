<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'name'           => ['type' => 'VARCHAR', 'constraint' => '100'],
            'email'          => ['type' => 'VARCHAR', 'constraint' => '100'],
            'username'       => ['type' => 'VARCHAR', 'constraint' => '50'],
            'password'       => ['type' => 'VARCHAR', 'constraint' => '255'],
            'role'           => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'kader'],
            'posyandu_id'    => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'is_active'      => ['type' => 'BOOLEAN', 'default' => true],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}