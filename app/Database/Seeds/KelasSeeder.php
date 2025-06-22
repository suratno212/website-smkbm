<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data kelas sebelum insert baru
        $this->db->table('kelas')->truncate();
        $this->db->query("ALTER TABLE kelas AUTO_INCREMENT = 1");

        // Data kelas
        $kelasData = [
            [
                'nama_kelas' => 'X TKJ 1',
                'tingkat' => 'X',
                'jurusan_id' => 1, // TKJ
            ],
            [
                'nama_kelas' => 'X TKJ 2',
                'tingkat' => 'X',
                'jurusan_id' => 1, // TKJ
            ],
            [
                'nama_kelas' => 'X RPL 1',
                'tingkat' => 'X',
                'jurusan_id' => 2, // RPL
            ],
            [
                'nama_kelas' => 'X MM 1',
                'tingkat' => 'X',
                'jurusan_id' => 3, // MM
            ],
            [
                'nama_kelas' => 'XI TKJ 1',
                'tingkat' => 'XI',
                'jurusan_id' => 1, // TKJ
            ],
            [
                'nama_kelas' => 'XI RPL 1',
                'tingkat' => 'XI',
                'jurusan_id' => 2, // RPL
            ]
        ];

        // Insert data kelas
        $this->db->table('kelas')->insertBatch($kelasData);

        // Data wali kelas
        $waliKelasData = [
            [
                'guru_id' => 1, // Ahmad Supriadi
                'kelas_id' => 1,
                'tahun_akademik_id' => 1
            ],
            [
                'guru_id' => 2, // Siti Nurhaliza
                'kelas_id' => 2,
                'tahun_akademik_id' => 1
            ],
            [
                'guru_id' => 3, // Budi Santoso
                'kelas_id' => 3,
                'tahun_akademik_id' => 1
            ],
            [
                'guru_id' => 4, // Rina Marlina
                'kelas_id' => 4,
                'tahun_akademik_id' => 1
            ],
            [
                'guru_id' => 5, // Joko Widodo
                'kelas_id' => 5,
                'tahun_akademik_id' => 1
            ],
            [
                'guru_id' => 6, // Sri Wahyuni
                'kelas_id' => 6,
                'tahun_akademik_id' => 1
            ]
        ];

        // Insert data wali kelas
        $this->db->table('wali_kelas')->insertBatch($waliKelasData);
    }
} 