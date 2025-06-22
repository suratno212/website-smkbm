<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WaliKelasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'guru_id'  => 1,
                'kelas_id' => 1,
                'tahun_akademik_id' => 1,
            ],
            [
                'guru_id'  => 1,
                'kelas_id' => 2,
                'tahun_akademik_id' => 1,
            ],
        ];

        $this->db->table('wali_kelas')->insertBatch($data);
    }
} 