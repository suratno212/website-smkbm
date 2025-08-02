<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AgamaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id' => 1, 'nama_agama' => 'Islam'],
            ['id' => 2, 'nama_agama' => 'Kristen'],
            ['id' => 3, 'nama_agama' => 'Katolik'],
            ['id' => 4, 'nama_agama' => 'Hindu'],
            ['id' => 5, 'nama_agama' => 'Buddha'],
            ['id' => 6, 'nama_agama' => 'Konghucu'],
            ['id' => 7, 'nama_agama' => 'Lainnya']
        ];
        $this->db->table('agama')->insertBatch($data);
    }
} 