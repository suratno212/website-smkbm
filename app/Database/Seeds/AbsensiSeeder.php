<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class AbsensiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'siswa_id' => 1,
                'tanggal'  => '2024-03-20',
                'status'   => 'Hadir',
            ],
            [
                'siswa_id' => 1,
                'tanggal'  => '2024-03-21',
                'status'   => 'Hadir',
            ],
        ];
        $this->db->table('absensi')->insertBatch($data);
    }
} 