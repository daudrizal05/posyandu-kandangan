<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGiziFieldsToBalita extends Migration
{
    public function up()
    {
        $fields = [
            'berat' => [
                'type' => 'NUMERIC',
                'constraint' => '5,2',
                'null' => true,
            ],
            'tinggi' => [
                'type' => 'NUMERIC',
                'constraint' => '5,2',
                'null' => true,
            ],
            'bb_u' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'zs_bb_u' => [
                'type' => 'NUMERIC',
                'constraint' => '5,2',
                'null' => true,
            ],
            'tb_u' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'zs_tb_u' => [
                'type' => 'NUMERIC',
                'constraint' => '5,2',
                'null' => true,
            ],
            'bb_tb' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'zs_bb_tb' => [
                'type' => 'NUMERIC',
                'constraint' => '5,2',
                'null' => true,
            ],
        ];
        
        $this->forge->addColumn('balita', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('balita', ['berat', 'tinggi', 'bb_u', 'zs_bb_u', 'tb_u', 'zs_tb_u', 'bb_tb', 'zs_bb_tb']);
    }
}
