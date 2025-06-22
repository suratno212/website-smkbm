<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RuanganSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama
        $this->db->table('ruangan')->emptyTable();

        $now = date('Y-m-d H:i:s');
        $data = [
            [
                'nama_ruangan' => 'Lab Komputer 1',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_ruangan' => 'Lab Komputer 2',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_ruangan' => 'Ruang Kelas X TKJ 1',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_ruangan' => 'Ruang Kelas X TKJ 2',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_ruangan' => 'Ruang Kelas XI RPL 1',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            // Kelas XI TKJ
            [
                'nama_ruangan' => 'XI TKJ 1',
                'created_at'   => $now,
                'updated_at'   => $now
            ],
            [
                'nama_ruangan' => 'XI TKJ 2',
                'created_at'   => $now,
                'updated_at'   => $now
            ],
            // Kelas XII TKJ
            [
                'nama_ruangan' => 'XII TKJ 1',
                'created_at'   => $now,
                'updated_at'   => $now
            ],
            [
                'nama_ruangan' => 'XII TKJ 2',
                'created_at'   => $now,
                'updated_at'   => $now
            ],
            // Kelas TBSM
            [
                'nama_ruangan' => 'X TBSM',
                'created_at'   => $now,
                'updated_at'   => $now
            ],
            [
                'nama_ruangan' => 'XI TBSM',
                'created_at'   => $now,
                'updated_at'   => $now
            ],
            [
                'nama_ruangan' => 'XII TBSM',
                'created_at'   => $now,
                'updated_at'   => $now
            ],
            ['nama_ruangan' => 'Ruang Kelas 1', 'created_at' => $now, 'updated_at' => $now],
        ];

        $this->db->table('ruangan')->insertBatch($data);
    }
} 