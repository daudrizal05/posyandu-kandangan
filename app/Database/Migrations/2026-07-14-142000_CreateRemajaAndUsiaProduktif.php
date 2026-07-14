<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRemajaAndUsiaProduktif extends Migration
{
    public function up()
    {
        // 1. Table remaja
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'posyandu_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'unique'     => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'berat_badan' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'tinggi_badan' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'lila' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'tekanan_darah' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'hb' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('remaja', true);

        // 2. Table usia_produktif
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'posyandu_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'unique'     => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'berat_badan' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'tinggi_badan' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'lingkar_perut' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'tekanan_darah' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'gula_darah' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'kolesterol' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'asam_urat' => [
                'type'       => 'FLOAT',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('usia_produktif', true);
    }

    public function down()
    {
        $this->forge->dropTable('usia_produktif', true);
        $this->forge->dropTable('remaja', true);
    }
}
