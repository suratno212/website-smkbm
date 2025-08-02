<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GuruUpinIpinSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'username' => '10000001',
                'password' => password_hash('1995-01-01', PASSWORD_DEFAULT),
                'role' => 'guru',
            ],
            [
                'username' => '10000002',
                'password' => password_hash('1995-01-02', PASSWORD_DEFAULT),
                'role' => 'guru',
            ]
        ];
        $this->db->table('users')->insertBatch($users);
        $userIds = $this->db->table('users')
            ->whereIn('username', ['10000001', '10000002'])
            ->get()->getResultArray();
        $guru = [
            [
                'user_id' => $userIds[0]['id'],
                'nama' => 'Upin',
                'nip_nuptk' => '10000001',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'tanggal_lahir' => '1995-01-01',
                'kd_mapel' => 1,
                'alamat' => 'Kampung Durian Runtuh',
                'no_hp' => '081234567891',
            ],
            [
                'user_id' => $userIds[1]['id'],
                'nama' => 'Ipin',
                'nip_nuptk' => '10000002',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'tanggal_lahir' => '1995-01-02',
                'kd_mapel' => 1,
                'alamat' => 'Kampung Durian Runtuh',
                'no_hp' => '081234567892',
            ]
        ];
        $this->db->table('guru')->insertBatch($guru);
    }
} 