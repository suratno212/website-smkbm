<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EkstrakurikulerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_ekstrakurikuler' => 'drum band',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_ekstrakurikuler' => 'pramuka',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('ekstrakurikuler')->insertBatch($data);
    }
} 