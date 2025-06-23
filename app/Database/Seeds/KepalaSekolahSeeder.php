<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KepalaSekolahSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'kepsek',
            'password' => password_hash('12345678', PASSWORD_DEFAULT),
            'role' => 'kepala_sekolah',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('users')->insert($data);
    }
} 