<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class AbsensiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kd_absensi' => 'ABS001',
                'nis' => '2024001',
                'tanggal'  => '2024-03-20',
                'status'   => 'Hadir',
            ],
            [
                'kd_absensi' => 'ABS002',
                'nis' => '2024001',
                'tanggal'  => '2024-03-21',
                'status'   => 'Hadir',
            ],
        ];
        $this->db->table('absensi')->insertBatch($data);
    }
} 