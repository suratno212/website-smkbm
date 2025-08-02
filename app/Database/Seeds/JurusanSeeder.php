<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key check
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        // Hapus semua data jurusan sebelum insert baru
        $this->db->table('jurusan')->truncate();
        $this->db->query("ALTER TABLE jurusan AUTO_INCREMENT = 1");
        // Aktifkan kembali foreign key check
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            [
                'kd_jurusan' => 'TKJ',
                'nama_jurusan' => 'Teknik Komputer dan Jaringan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_jurusan' => 'TBSM',
                'nama_jurusan' => 'Teknik Bisnis Sepeda Motor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('jurusan')->insertBatch($data);
    }
} 