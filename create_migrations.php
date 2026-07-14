<?php

$dir = __DIR__ . '/app/Database/Migrations';
$files = scandir($dir);

$migrations = [
    'Posyandu' => <<<'PHP'
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posyandu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'nama_posyandu'  => ['type' => 'VARCHAR', 'constraint' => '100'],
            'dusun'          => ['type' => 'VARCHAR', 'constraint' => '100'],
            'urutan'         => ['type' => 'INT'],
            'alamat'         => ['type' => 'TEXT', 'null' => true],
            'kader'          => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'status'         => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'aktif'],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('posyandu');
    }

    public function down()
    {
        $this->forge->dropTable('posyandu');
    }
}
PHP,

    'Users' => <<<'PHP'
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
PHP,

    'OrangTua' => <<<'PHP'
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrangTua extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'nama_ayah'      => ['type' => 'VARCHAR', 'constraint' => '100'],
            'nama_ibu'       => ['type' => 'VARCHAR', 'constraint' => '100'],
            'nik_ibu'        => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'no_hp'          => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'alamat'         => ['type' => 'TEXT'],
            'posyandu_id'    => ['type' => 'BIGINT', 'unsigned' => true],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('orang_tua');
    }

    public function down()
    {
        $this->forge->dropTable('orang_tua');
    }
}
PHP,

    'Balita' => <<<'PHP'
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Balita extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                  => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'nik'                 => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'nama_balita'         => ['type' => 'VARCHAR', 'constraint' => '100'],
            'jenis_kelamin'       => ['type' => 'VARCHAR', 'constraint' => '1'],
            'tempat_lahir'        => ['type' => 'VARCHAR', 'constraint' => '50'],
            'tanggal_lahir'       => ['type' => 'DATE'],
            'orang_tua_id'        => ['type' => 'BIGINT', 'unsigned' => true],
            'posyandu_id'         => ['type' => 'BIGINT', 'unsigned' => true],
            'berat_badan_lahir'   => ['type' => 'NUMERIC', 'constraint' => '5,2'],
            'panjang_badan_lahir' => ['type' => 'NUMERIC', 'constraint' => '5,2'],
            'foto'                => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'status'              => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'aktif'],
            'created_at'          => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'          => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'          => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('orang_tua_id', 'orang_tua', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('posyandu_id', 'posyandu', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('balita');
    }

    public function down()
    {
        $this->forge->dropTable('balita');
    }
}
PHP,

    'Pengukuran' => <<<'PHP'
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
            'tanggal_ukur'     => ['type' => 'DATE'],
            'usia_bulan'       => ['type' => 'INT'],
            'berat_badan'      => ['type' => 'NUMERIC', 'constraint' => '5,2'],
            'tinggi_badan'     => ['type' => 'NUMERIC', 'constraint' => '5,2'],
            'lingkar_kepala'   => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'lila'             => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'zscore_bb_u'      => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'zscore_tb_u'      => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'zscore_bb_tb'     => ['type' => 'NUMERIC', 'constraint' => '5,2', 'null' => true],
            'status_gizi'      => ['type' => 'VARCHAR', 'constraint' => '50'],
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
PHP,

    'Berita' => <<<'PHP'
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
PHP,

    'GaleriKategori' => <<<'PHP'
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GaleriKategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'nama_kategori'  => ['type' => 'VARCHAR', 'constraint' => '100'],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('galeri_kategori');
    }

    public function down()
    {
        $this->forge->dropTable('galeri_kategori');
    }
}
PHP,

    'Galeri' => <<<'PHP'
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Galeri extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'kategori_id'    => ['type' => 'BIGINT', 'unsigned' => true, 'null' => true],
            'judul'          => ['type' => 'VARCHAR', 'constraint' => '255'],
            'gambar'         => ['type' => 'VARCHAR', 'constraint' => '255'],
            'tanggal'        => ['type' => 'DATE', 'null' => true],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kategori_id', 'galeri_kategori', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('galeri');
    }

    public function down()
    {
        $this->forge->dropTable('galeri');
    }
}
PHP,

    'Download' => <<<'PHP'
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Download extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'judul_file'     => ['type' => 'VARCHAR', 'constraint' => '255'],
            'file'           => ['type' => 'VARCHAR', 'constraint' => '255'],
            'kategori'       => ['type' => 'VARCHAR', 'constraint' => '50'],
            'tanggal_upload' => ['type' => 'DATE', 'null' => true],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('download');
    }

    public function down()
    {
        $this->forge->dropTable('download');
    }
}
PHP,

    'HalamanStatis' => <<<'PHP'
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HalamanStatis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'slug'           => ['type' => 'VARCHAR', 'constraint' => '255', 'unique' => true],
            'judul'          => ['type' => 'VARCHAR', 'constraint' => '255'],
            'konten'         => ['type' => 'TEXT'],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('halaman_statis');
    }

    public function down()
    {
        $this->forge->dropTable('halaman_statis');
    }
}
PHP,

    'Infografis' => <<<'PHP'
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
            'gambar'         => ['type' => 'VARCHAR', 'constraint' => '255'],
            'deskripsi'      => ['type' => 'TEXT', 'null' => true],
            'tanggal'        => ['type' => 'DATE', 'null' => true],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('infografis');
    }

    public function down()
    {
        $this->forge->dropTable('infografis');
    }
}
PHP,

    'KontakPesan' => <<<'PHP'
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KontakPesan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGSERIAL', 'unsigned' => true, 'auto_increment' => true],
            'nama'           => ['type' => 'VARCHAR', 'constraint' => '100'],
            'email'          => ['type' => 'VARCHAR', 'constraint' => '100'],
            'no_hp'          => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'pesan'          => ['type' => 'TEXT'],
            'is_read'        => ['type' => 'BOOLEAN', 'default' => false],
            'created_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kontak_pesan');
    }

    public function down()
    {
        $this->forge->dropTable('kontak_pesan');
    }
}
PHP
];

foreach ($files as $f) {
    if (strpos($f, '.php') !== false) {
        foreach ($migrations as $className => $content) {
            if (strpos($f, '_' . $className . '.php') !== false) {
                file_put_contents($dir . '/' . $f, $content);
                echo "Updated $f\n";
            }
        }
    }
}

// Seeders
$seedsDir = __DIR__ . '/app/Database/Seeds';
$seeds = [
    'PosyanduSeeder' => <<<'PHP'
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_posyandu' => 'Posyandu Ploso Rejo', 'dusun' => 'Ploso Rejo', 'urutan' => 1, 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Tengger', 'dusun' => 'Tengger', 'urutan' => 2, 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Desan', 'dusun' => 'Desan', 'urutan' => 3, 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Kandangan I', 'dusun' => 'Kandangan I', 'urutan' => 4, 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Kandangan II', 'dusun' => 'Kandangan II', 'urutan' => 5, 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Karang Tejo', 'dusun' => 'Karang Tejo', 'urutan' => 6, 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Sidomulyo I', 'dusun' => 'Sidomulyo I', 'urutan' => 7, 'status' => 'aktif'],
            ['nama_posyandu' => 'Posyandu Sidomulyo II', 'dusun' => 'Sidomulyo II', 'urutan' => 8, 'status' => 'aktif'],
        ];

        foreach ($data as $row) {
            $row['created_at'] = date('Y-m-d H:i:s');
            $row['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('posyandu')->insert($row);
        }
    }
}
PHP,
    'UserSeeder' => <<<'PHP'
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Super Administrator',
                'email'      => 'superadmin@estunting.com',
                'username'   => 'superadmin',
                'password'   => password_hash('password', PASSWORD_DEFAULT),
                'role'       => 'superadmin',
                'is_active'  => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Admin Dinas',
                'email'      => 'dinas@estunting.com',
                'username'   => 'admindinas',
                'password'   => password_hash('password', PASSWORD_DEFAULT),
                'role'       => 'admin_dinas',
                'is_active'  => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
PHP
];

foreach ($seeds as $className => $content) {
    file_put_contents($seedsDir . '/' . $className . '.php', $content);
    echo "Updated $className.php\n";
}

echo "All migrations and seeders written successfully.\n";
