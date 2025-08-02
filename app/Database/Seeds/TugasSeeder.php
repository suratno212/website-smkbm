<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class TugasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kd_tugas'   => 'TGS003',
                'nik_nip'   => '198001010001',
                'kd_mapel'  => 'MTK',
                'kd_kelas'  => 'X-TKJ-1',
                'judul'     => 'Tugas Matematika',
                'deskripsi' => 'Deskripsi tugas matematika',
                'deadline'   => '2024-03-25 23:59:59',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kd_tugas'   => 'TGS004',
                'nik_nip'   => '198101010002',
                'kd_mapel'  => 'BIN',
                'kd_kelas'  => 'X-TKJ-2',
                'judul'     => 'Tugas Bahasa Indonesia',
                'deskripsi' => 'Deskripsi tugas bahasa indonesia',
                'deadline'   => '2024-03-26 23:59:59',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];
        $this->db->table('tugas')->insertBatch($data);
    }
} 