<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyStatusGiziPengukuran extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE pengukuran ALTER COLUMN status_gizi TYPE VARCHAR(50)");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE pengukuran ALTER COLUMN status_gizi TYPE VARCHAR(20)");
    }
}
