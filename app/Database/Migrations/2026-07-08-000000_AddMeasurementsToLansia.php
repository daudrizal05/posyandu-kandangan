<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMeasurementsToLansia extends Migration
{
    public function up()
    {
        $fields = [
            'umur' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'lingkar_lengan_atas' => [
                'type' => 'NUMERIC',
                'constraint' => '5,2',
                'null' => true,
            ],
            'bb' => [
                'type' => 'NUMERIC',
                'constraint' => '5,2',
                'null' => true,
            ],
            'tb' => [
                'type' => 'NUMERIC',
                'constraint' => '5,2',
                'null' => true,
            ],
            'lingkar_pinggang' => [
                'type' => 'NUMERIC',
                'constraint' => '5,2',
                'null' => true,
            ],
            'imt' => [
                'type' => 'NUMERIC',
                'constraint' => '5,2',
                'null' => true,
            ],
            'no_bpjs' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'keluhan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tensi' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'obat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        
        $this->forge->addColumn('lansia', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('lansia', ['umur', 'lingkar_lengan_atas', 'bb', 'tb', 'lingkar_pinggang', 'imt', 'no_bpjs', 'keluhan', 'tensi', 'obat']);
    }
}
