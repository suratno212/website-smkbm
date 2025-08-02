<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TahunAkademikSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kd_tahun_akademik' => '2024GJ',
                'tahun' => '2024/2025',
                'semester' => 'Ganjil',
                'status' => 'Aktif',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2024-12-20',
            ],
            [
                'kd_tahun_akademik' => '2024GN',
                'tahun' => '2024/2025',
                'semester' => 'Genap',
                'status' => 'Tidak Aktif',
                'tanggal_mulai' => '2025-01-10',
                'tanggal_selesai' => '2025-06-20',
            ],
        ];

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->db->table('tahun_akademik')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
        $this->db->table('tahun_akademik')->insertBatch($data);
    }
} 