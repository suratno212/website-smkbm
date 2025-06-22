<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DeleteGuruSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('guru')->truncate();
    }
} 