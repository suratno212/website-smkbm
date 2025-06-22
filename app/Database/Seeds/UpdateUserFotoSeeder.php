<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateUserFotoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'foto' => 'admin-profile.jpg'
            ],
            [
                'username' => 'guru1',
                'foto' => 'guru1-profile.jpg'
            ],
            [
                'username' => 'guru2',
                'foto' => 'guru2-profile.jpg'
            ],
            [
                'username' => 'siswa1',
                'foto' => 'siswa1-profile.jpg'
            ],
            [
                'username' => 'siswa2',
                'foto' => 'siswa2-profile.jpg'
            ]
        ];

        foreach ($data as $user) {
            $this->db->table('users')
                     ->where('username', $user['username'])
                     ->update(['foto' => $user['foto']]);
        }
    }
}
