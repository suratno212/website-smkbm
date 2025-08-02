<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResetSiswaSeeder extends Seeder
{
    public function run()
    {
        // Hapus data siswa yang ada
        $this->db->table('siswa')->where('id >', 0)->delete();
        
        // Reset auto increment
        $this->db->query("ALTER TABLE siswa AUTO_INCREMENT = 1");
        
        // Ambil user_id siswa dari tabel users berdasarkan username (NIS)
        $users = $this->db->table('users')->where('role', 'siswa')->get()->getResultArray();
        $userMap = [];
        foreach ($users as $u) {
            $userMap[$u['username']] = $u['id'];
        }
        
        // Data siswa
        $data = [
            [
                'user_id' => $userMap['2024001'] ?? null,
                'nis' => '2024001',
                'nama' => 'Ahmad Fadillah',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2006-03-15',
                'agama' => 'Islam',
                'kd_kelas' => 1, // X TKJ 1
                'kd_jurusan' => 1, // TKJ
                'alamat' => 'Jl. Ahmad No. 1, Jakarta',
                'no_hp' => '081234567896'
            ],
            [
                'user_id' => $userMap['2024002'] ?? null,
                'nis' => '2024002',
                'nama' => 'Siti Aisyah',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2006-05-20',
                'agama' => 'Islam',
                'kd_kelas' => 1, // X TKJ 1
                'kd_jurusan' => 1, // TKJ
                'alamat' => 'Jl. Siti No. 2, Bandung',
                'no_hp' => '081234567897'
            ],
            [
                'user_id' => $userMap['2024003'] ?? null,
                'nis' => '2024003',
                'nama' => 'Budi Prasetyo',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2006-07-10',
                'agama' => 'Islam',
                'kd_kelas' => 2, // X TKJ 2
                'kd_jurusan' => 1, // TKJ
                'alamat' => 'Jl. Budi No. 3, Surabaya',
                'no_hp' => '081234567898'
            ],
            [
                'user_id' => $userMap['2024004'] ?? null,
                'nis' => '2024004',
                'nama' => 'Rina Safitri',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2006-09-25',
                'agama' => 'Islam',
                'kd_kelas' => 3, // X RPL 1
                'kd_jurusan' => 2, // RPL
                'alamat' => 'Jl. Rina No. 4, Semarang',
                'no_hp' => '081234567899'
            ],
            [
                'user_id' => $userMap['2024005'] ?? null,
                'nis' => '2024005',
                'nama' => 'Joko Susilo',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Solo',
                'tanggal_lahir' => '2006-11-30',
                'agama' => 'Islam',
                'kd_kelas' => 4, // X MM 1
                'kd_jurusan' => 3, // MM
                'alamat' => 'Jl. Joko No. 5, Solo',
                'no_hp' => '081234567900'
            ],
            [
                'user_id' => 13,
                'nis' => '2024006',
                'nama' => 'Sri Wahyuni',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2006-12-05',
                'agama' => 'Islam',
                'kd_kelas' => 5, // XI TKJ 1
                'kd_jurusan' => 1, // TKJ
                'alamat' => 'Jl. Sri No. 6, Yogyakarta',
                'no_hp' => '081234567901'
            ]
        ];

        $this->db->table('siswa')->insertBatch($data);
    }
} 