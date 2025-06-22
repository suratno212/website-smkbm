<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data guru sebelum insert baru
        $this->db->table('guru')->truncate();
        $this->db->query("ALTER TABLE guru AUTO_INCREMENT = 1");

        $data = [
            [
                'user_id'       => 2,
                'nip_nuptk'     => '198001012010011001',
                'nama'          => 'Guru Satu',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir'  => 'Jakarta',
                'tanggal_lahir' => '1980-01-01',
                'agama'         => 'Islam',
                'mapel_id'      => 1,
                'alamat'        => 'Jl. Guru No. 1',
                'no_hp'         => '081234567890',
            ],
        ];

        $this->db->table('guru')->insertBatch($data);
    }
} 