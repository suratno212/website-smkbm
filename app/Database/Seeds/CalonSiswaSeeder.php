<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CalonSiswaSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel();
        $calonSiswaModel = new \App\Models\CalonSiswaModel();

        // Data calon siswa untuk testing
        $calonSiswaData = [
            [
                'nama' => 'Ahmad Fadillah',
                'email' => 'ahmad.fadillah@test.com',
                'tanggal_lahir' => '2008-05-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 123, Bandar Lampung',
                'no_hp' => '081234567890',
                'asal_sekolah' => 'SMP Negeri 1 Bandar Lampung',
                'jurusan_pilihan' => 'RPL',
                'status_pendaftaran' => 'terdaftar',
                'status_tes' => 'belum_tes'
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@test.com',
                'tanggal_lahir' => '2008-08-20',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Sudirman No. 456, Bandar Lampung',
                'no_hp' => '081234567891',
                'asal_sekolah' => 'SMP Negeri 2 Bandar Lampung',
                'jurusan_pilihan' => 'TBSM',
                'status_pendaftaran' => 'terdaftar',
                'status_tes' => 'belum_tes'
            ],
            [
                'nama' => 'Muhammad Rizki',
                'email' => 'muhammad.rizki@test.com',
                'tanggal_lahir' => '2008-03-10',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Gatot Subroto No. 789, Bandar Lampung',
                'no_hp' => '081234567892',
                'asal_sekolah' => 'SMP Negeri 3 Bandar Lampung',
                'jurusan_pilihan' => 'TKJ',
                'status_pendaftaran' => 'terdaftar',
                'status_tes' => 'belum_tes'
            ]
        ];

        foreach ($calonSiswaData as $data) {
            // Buat user untuk calon siswa
            $userData = [
                'username' => $data['email'],
                'email' => $data['email'],
                'password' => password_hash($data['tanggal_lahir'], PASSWORD_DEFAULT),
                'role' => 'calon_siswa',
                'nama' => $data['nama']
            ];

            $userId = $userModel->insert($userData);
            if (!$userId) {
                echo "Gagal insert user: ".print_r($userModel->errors(), true)."\n";
                continue;
            }

            // Buat data calon siswa
            $data['user_id'] = $userId;
            if (!$calonSiswaModel->insert($data)) {
                echo "Gagal insert calon siswa: ".print_r($calonSiswaModel->errors(), true)."\n";
            } else {
                echo "Berhasil insert calon siswa: ".$data['nama']."\n";
            }
        }

        echo "Seeder CalonSiswa selesai dijalankan!\n";
    }
} 