<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'username' => 'guru1',
                'password' => password_hash('guru123', PASSWORD_DEFAULT),
                'role'     => 'guru',
            ],
            [
                'username' => 'siswa1',
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'role'     => 'siswa',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
} 