<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class PengumpulanTugasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tugas_id' => 1,
                'siswa_id' => 1,
                'file_tugas' => 'test_file_1.txt',
                'status' => 'Dikumpulkan',
                'nilai' => 85,
                'catatan' => 'Bagus, tapi bisa lebih baik',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'tugas_id' => 1,
                'siswa_id' => 7,
                'file_tugas' => 'test_file_2.txt',
                'status' => 'Dikumpulkan',
                'nilai' => 90,
                'catatan' => 'Sangat bagus!',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'tugas_id' => 2,
                'siswa_id' => 1,
                'file_tugas' => 'test_file_1.txt',
                'status' => 'Terlambat',
                'nilai' => 75,
                'catatan' => 'Terlambat mengumpulkan',
                'created_at' => date('Y-m-d H:i:s', strtotime('+1 day')),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('pengumpulan_tugas')->insertBatch($data);
    }
} 