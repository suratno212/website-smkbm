<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class NilaiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'siswa_id'         => 1,
                'mapel_id'         => 1,
                'tahun_akademik_id' => 1,
                'uts'              => 85,
                'uas'              => 90,
                'tugas'            => 88,
                'akhir'            => 88,
            ],
            [
                'siswa_id'         => 1,
                'mapel_id'         => 2,
                'tahun_akademik_id' => 1,
                'uts'              => 80,
                'uas'              => 85,
                'tugas'            => 82,
                'akhir'            => 82,
            ],
        ];
        $this->db->table('nilai')->insertBatch($data);
    }
} 