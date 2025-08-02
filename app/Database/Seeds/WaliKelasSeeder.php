<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WaliKelasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kd_kelas' => 'X-TKJ-1',
                'nik_nip' => '198001010001',
                'kd_tahun_akademik' => '2024GJ',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_kelas' => 'X-TKJ-2',
                'nik_nip' => '198101010002',
                'kd_tahun_akademik' => '2024GJ',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('wali_kelas')->insertBatch($data);
    }
} 