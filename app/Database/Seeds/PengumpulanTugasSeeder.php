<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PengumpulanTugasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kd_pengumpulan' => 'PGM001',
                'kd_tugas' => 'TGS003',
                'nis' => '2024001',
                'file_tugas' => 'tugas_matematika_2024001.pdf',
                'status' => 'dikumpulkan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_pengumpulan' => 'PGM002',
                'kd_tugas' => 'TGS003',
                'nis' => '2024002',
                'file_tugas' => 'tugas_matematika_2024002.pdf',
                'status' => 'dikumpulkan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_pengumpulan' => 'PGM003',
                'kd_tugas' => 'TGS004',
                'nis' => '2024001',
                'file_tugas' => 'tugas_bahasa_indonesia_2024001.pdf',
                'status' => 'dikumpulkan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_pengumpulan' => 'PGM004',
                'kd_tugas' => 'TGS004',
                'nis' => '2024002',
                'file_tugas' => 'tugas_bahasa_indonesia_2024002.pdf',
                'status' => 'dikumpulkan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('pengumpulan_tugas')->insertBatch($data);
    }
} 