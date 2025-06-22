<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data siswa sebelum insert baru
        $this->db->table('siswa')->truncate();
        $this->db->query("ALTER TABLE siswa AUTO_INCREMENT = 1");

        // Data siswa
        $data = [
            [
                'user_id' => 8,
                'nisn' => '2024001',
                'nama' => 'Ahmad Fadillah',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2006-03-15',
                'agama' => 'Islam',
                'kelas_id' => 1, // X TKJ 1
                'jurusan_id' => 1, // TKJ
                'alamat' => 'Jl. Ahmad No. 1, Jakarta',
                'no_hp' => '081234567896'
            ],
            [
                'user_id' => 9,
                'nisn' => '2024002',
                'nama' => 'Siti Aisyah',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2006-05-20',
                'agama' => 'Islam',
                'kelas_id' => 1, // X TKJ 1
                'jurusan_id' => 1, // TKJ
                'alamat' => 'Jl. Siti No. 2, Bandung',
                'no_hp' => '081234567897'
            ],
            [
                'user_id' => 10,
                'nisn' => '2024003',
                'nama' => 'Budi Prasetyo',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2006-07-10',
                'agama' => 'Islam',
                'kelas_id' => 2, // X TKJ 2
                'jurusan_id' => 1, // TKJ
                'alamat' => 'Jl. Budi No. 3, Surabaya',
                'no_hp' => '081234567898'
            ],
            [
                'user_id' => 11,
                'nisn' => '2024004',
                'nama' => 'Rina Safitri',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2006-09-25',
                'agama' => 'Islam',
                'kelas_id' => 3, // X RPL 1
                'jurusan_id' => 2, // RPL
                'alamat' => 'Jl. Rina No. 4, Semarang',
                'no_hp' => '081234567899'
            ],
            [
                'user_id' => 12,
                'nisn' => '2024005',
                'nama' => 'Joko Susilo',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Solo',
                'tanggal_lahir' => '2006-11-30',
                'agama' => 'Islam',
                'kelas_id' => 4, // X MM 1
                'jurusan_id' => 3, // MM
                'alamat' => 'Jl. Joko No. 5, Solo',
                'no_hp' => '081234567900'
            ],
            [
                'user_id' => 13,
                'nisn' => '2024006',
                'nama' => 'Sri Wahyuni',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2006-12-05',
                'agama' => 'Islam',
                'kelas_id' => 5, // XI TKJ 1
                'jurusan_id' => 1, // TKJ
                'alamat' => 'Jl. Sri No. 6, Yogyakarta',
                'no_hp' => '081234567901'
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
                'kelas_id' => 1, // Pastikan kelas dengan ID 1 ada
                'jurusan_id' => 1, // Pastikan jurusan dengan ID 1 ada
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