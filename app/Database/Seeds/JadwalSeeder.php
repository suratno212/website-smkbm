<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kd_jadwal'      => 'JADWAL001',
                'kd_kelas'       => 'X-TKJ-1',
                'kd_mapel'       => 'MTK',
                'nik_nip'        => '198001010001',
                'kd_tahun_akademik' => 1,
                'hari'           => 'Senin',
                'jam_mulai'      => '07:00:00',
                'jam_selesai'    => '08:30:00',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s')
            ],
            [
                'kd_jadwal'      => 'JADWAL002',
                'kd_kelas'       => 'X-TKJ-1',
                'kd_mapel'       => 'BIN',
                'nik_nip'        => '198101010002',
                'kd_tahun_akademik' => 1,
                'hari'           => 'Senin',
                'jam_mulai'      => '08:30:00',
                'jam_selesai'    => '10:00:00',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s')
            ],
            [
                'kd_jadwal'      => 'JADWAL003',
                'kd_kelas'       => 'X-TKJ-2',
                'kd_mapel'       => 'MTK',
                'nik_nip'        => '198001010001',
                'kd_tahun_akademik' => 1,
                'hari'           => 'Selasa',
                'jam_mulai'      => '07:00:00',
                'jam_selesai'    => '08:30:00',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s')
            ],
            [
                'kd_jadwal'      => 'JADWAL004',
                'kd_kelas'       => 'X-TKJ-2',
                'kd_mapel'       => 'BIN',
                'nik_nip'        => '198101010002',
                'kd_tahun_akademik' => 1,
                'hari'           => 'Selasa',
                'jam_mulai'      => '08:30:00',
                'jam_selesai'    => '10:00:00',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s')
            ],
            [
                'kd_jadwal'      => 'JADWAL005',
                'kd_kelas'       => 'X-TKJ-1',
                'kd_mapel'       => 'MTK',
                'nik_nip'        => '198001010001',
                'kd_tahun_akademik' => 1,
                'hari'           => 'Rabu',
                'jam_mulai'      => '07:00:00',
                'jam_selesai'    => '08:30:00',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('jadwal')->insertBatch($data);
    }
} 