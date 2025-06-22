<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data jurusan sebelum insert baru
        $this->db->table('jurusan')->truncate();
        $this->db->query("ALTER TABLE jurusan AUTO_INCREMENT = 1");

        $data = [
            ['nama_jurusan' => 'RPL'],
            ['nama_jurusan' => 'TKJ'],
            ['nama_jurusan' => 'MM'],
            ['nama_jurusan' => 'OTKP'],
            ['nama_jurusan' => 'BDP'],
            ['nama_jurusan' => 'AKL'],
        ];

        $this->db->table('jurusan')->insertBatch($data);
    }
} 