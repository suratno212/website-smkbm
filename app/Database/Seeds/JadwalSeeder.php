<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class JadwalSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kelas_id'         => 1,
                'mapel_id'         => 1,
                'guru_id'          => 1,
                'tahun_akademik_id' => 1,
                'hari'             => 'Senin',
                'jam_mulai'        => '07:00:00',
                'jam_selesai'      => '08:30:00',
            ],
            [
                'kelas_id'         => 1,
                'mapel_id'         => 2,
                'guru_id'          => 1,
                'tahun_akademik_id' => 1,
                'hari'             => 'Senin',
                'jam_mulai'        => '08:30:00',
                'jam_selesai'      => '10:00:00',
            ],
            [
                'kelas_id'         => 2,
                'mapel_id'         => 1,
                'guru_id'          => 2,
                'tahun_akademik_id' => 1,
                'hari'             => 'Selasa',
                'jam_mulai'        => '07:00:00',
                'jam_selesai'      => '08:30:00',
            ],
            [
                'kelas_id'         => 2,
                'mapel_id'         => 2,
                'guru_id'          => 2,
                'tahun_akademik_id' => 1,
                'hari'             => 'Selasa',
                'jam_mulai'        => '08:30:00',
                'jam_selesai'      => '10:00:00',
            ],
            [
                'kelas_id'         => 1,
                'mapel_id'         => 1,
                'guru_id'          => 1,
                'tahun_akademik_id' => 1,
                'hari'             => 'Rabu',
                'jam_mulai'        => '07:00:00',
                'jam_selesai'      => '08:30:00',
            ],
        ];
        $this->db->table('jadwal')->insertBatch($data);
    }
} 