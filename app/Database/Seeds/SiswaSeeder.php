<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key check
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        // Hapus semua data siswa sebelum insert baru
        $this->db->table('siswa')->truncate();
        $this->db->query("ALTER TABLE siswa AUTO_INCREMENT = 1");
        // Aktifkan kembali foreign key check
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        // Data siswa
        $data = [
            [
                'user_id' => 12,
                'nis' => '2024001',
                'nama' => 'Ahmad Fadillah',
                'tanggal_lahir' => '2008-01-15',
                'jenis_kelamin' => 'L',
                'agama_id' => 1,
                'kd_kelas' => 'X-TKJ-1', // X TKJ 1
                'kd_jurusan' => 'TKJ', // TKJ
                'alamat' => 'Jl. Sudirman No. 1, Jakarta',
                'no_hp' => '081234567890',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 9,
                'nis' => '2024002',
                'nama' => 'Siti Aisyah',
                'tanggal_lahir' => '2008-02-20',
                'jenis_kelamin' => 'P',
                'agama_id' => 1,
                'kd_kelas' => 'X-TKJ-1', // X TKJ 1
                'kd_jurusan' => 'TKJ', // TKJ
                'alamat' => 'Jl. Thamrin No. 2, Jakarta',
                'no_hp' => '081234567891',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 10,
                'nis' => '2024003',
                'nama' => 'Budi Prasetyo',
                'tanggal_lahir' => '2008-03-10',
                'jenis_kelamin' => 'L',
                'agama_id' => 1,
                'kd_kelas' => 'X-TKJ-2', // X TKJ 2
                'kd_jurusan' => 'TKJ', // TKJ
                'alamat' => 'Jl. Gatot Subroto No. 3, Jakarta',
                'no_hp' => '081234567892',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 11,
                'nis' => '2024004',
                'nama' => 'Rina Sari',
                'tanggal_lahir' => '2008-04-05',
                'jenis_kelamin' => 'P',
                'agama_id' => 1,
                'kd_kelas' => 'X-RPL-1', // X RPL 1
                'kd_jurusan' => 'RPL', // RPL
                'alamat' => 'Jl. Rasuna Said No. 4, Jakarta',
                'no_hp' => '081234567893',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 12,
                'nis' => '2024005',
                'nama' => 'Joko Susilo',
                'tanggal_lahir' => '2008-05-12',
                'jenis_kelamin' => 'L',
                'agama_id' => 1,
                'kd_kelas' => 'X-MM-1', // X MM 1
                'kd_jurusan' => 'MM', // MM
                'alamat' => 'Jl. Sudirman No. 5, Jakarta',
                'no_hp' => '081234567894',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 13,
                'nis' => '2024006',
                'nama' => 'Sri Wahyuni',
                'tanggal_lahir' => '2008-06-18',
                'jenis_kelamin' => 'P',
                'agama_id' => 1,
                'kd_kelas' => 'XI-TKJ-1', // XI TKJ 1
                'kd_jurusan' => 'TKJ', // TKJ
                'alamat' => 'Jl. Thamrin No. 6, Jakarta',
                'no_hp' => '081234567895',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('siswa')->insertBatch($data);

        // Tambah user siswa
        $userModel = new \App\Models\UserModel();
        $siswaModel = new \App\Models\SiswaModel();
        
        // Cek apakah user sudah ada
        $existingUser = $userModel->where('username', 'sura')->first();
        if (!$existingUser) {
            // Insert user
            $userData = [
                'username' => 'sura',
                'password' => password_hash('siswa123', PASSWORD_DEFAULT),
                'role' => 'siswa',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $user_id = $userModel->insert($userData);
            
            // Insert data siswa
            $siswaData = [
                'user_id' => $user_id,
                'nis' => '2024001',
                'nama' => 'Sura',
                'tanggal_lahir' => '2006-01-15',
                'kd_kelas' => 'X-TKJ-1', // Pastikan kelas dengan kode X-TKJ-1 ada
                'kd_jurusan' => 'TKJ', // Pastikan jurusan dengan kode TKJ ada
                'alamat' => 'Jl. Contoh No. 123',
                'no_hp' => '081234567890',
                'agama_id' => 1, // Pastikan agama dengan ID 1 ada
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $siswaModel->insert($siswaData);
            
            echo "User siswa 'sura' berhasil ditambahkan!\n";
        } else {
            echo "User siswa 'sura' sudah ada!\n";
        }
    }
} 