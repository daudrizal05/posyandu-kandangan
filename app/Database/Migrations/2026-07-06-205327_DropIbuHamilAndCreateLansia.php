<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropIbuHamilAndCreateLansia extends Migration
{
    public function up()
    {
        // Drop existing ibu_hamil and related tables if they exist
        if ($this->db->tableExists('ibu_hamil_anak')) {
            $this->forge->dropTable('ibu_hamil_anak', true);
        }
        if ($this->db->tableExists('ibu_hamil')) {
            $this->forge->dropTable('ibu_hamil', true);
        }

        // Create lansia table
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
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
                'unique'     => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tempat_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'tanggal_lahir' => [
                'type'       => 'DATE',
                'null'       => true,
            ],
            'alamat' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'status_pernikahan' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'kondisi_kesehatan' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'riwayat_penyakit' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lansia', true);
    }

    public function down()
    {
        $this->forge->dropTable('lansia', true);
    }
}
