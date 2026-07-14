<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class IbuHamilAnak extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'ibu_hamil_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nama_anak' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jenis_kelamin' => [
                'type'       => 'VARCHAR',
                'constraint' => '1',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'nama_ortu' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'posyandu_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'berat' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'tinggi' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'bb_u' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'zs_bb_u' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'tb_u' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'zs_tb_u' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'bb_tb' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'zs_bb_tb' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ibu_hamil_id', 'ibu_hamil', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ibu_hamil_anak');
    }

    public function down()
    {
        $this->forge->dropTable('ibu_hamil_anak');
    }
}
