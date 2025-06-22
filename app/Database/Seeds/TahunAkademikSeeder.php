<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TahunAkademikSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['tahun' => '2024/2025', 'semester' => 'Ganjil', 'status' => 'Aktif'],
            ['tahun' => '2024/2025', 'semester' => 'Genap', 'status' => 'Tidak Aktif'],
        ];

        $this->db->table('tahun_akademik')->insertBatch($data);
    }
} 