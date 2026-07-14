<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengukuran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'balita_id'        => ['type' => 'BIGINT', 'unsigned' => true],
            'posyandu_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'tanggal_pengukuran' => ['type' => 'DATE'],
            'usia_bulan'       => ['type' => 'INT'],
            'berat_badan'      => ['type' => 'NUMERIC', 'constraint' => '5,2'],
            'tinggi_badan'     => ['type' => 'NUMERIC', 'constraint' => '5,2'],
            'lingkar_kepala'   => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'lila'             => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'zscore_bb_u'      => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'zscore_tb_u'      => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'zscore_bb_tb'     => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'status_gizi'      => ['type' => 'VARCHAR', 'constraint' => '20'],
            'keterangan'       => ['type' => 'TEXT', 'null' => true],
            'petugas_id'       => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'created_at'       => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'       => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'       => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('balita_id', 'balita', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('petugas_id', 'users', 'id', 'SET NULL', 'SET NULL');
        
        $this->forge->createTable('pengukuran');
        
        // Add indices using raw queries if needed, or forge might support it in future, CI4 adds index for foreign keys often.
    }

    public function down()
    {
        $this->forge->dropTable('pengukuran');
    }
}