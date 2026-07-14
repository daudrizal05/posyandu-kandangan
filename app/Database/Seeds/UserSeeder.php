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
                'role'       => 'admin',
                'is_active'  => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Administrator',
                'email'      => 'admin@estunting.com',
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'is_active'  => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Admin Dinas',
                'email'      => 'dinas@estunting.com',
                'username'   => 'admindinas',
                'password'   => password_hash('password', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'is_active'  => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}