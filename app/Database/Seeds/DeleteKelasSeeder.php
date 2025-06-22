<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DeleteKelasSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('kelas')->truncate();
    }
} 