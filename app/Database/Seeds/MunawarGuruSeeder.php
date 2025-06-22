<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MunawarGuruSeeder extends Seeder
{
    public function run()
    {
        // Data untuk user
        $userData = [
            'username' => 'munawar',
            'password' => password_hash('1985-03-15', PASSWORD_DEFAULT), // Password: tanggal lahir
            'role' => 'guru',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Insert user
        $this->db->table('users')->insert($userData);
        $userId = $this->db->insertID();

        // Data untuk guru
        $guruData = [
            'user_id' => $userId,
            'nama' => 'Munawar.S.Pd',
            'tanggal_lahir' => '1985-03-15',
            'mapel_id' => 1, // Default mapel (bisa diubah sesuai kebutuhan)
            'alamat' => 'Jl. Raya Bekasi No. 123',
            'no_hp' => '081234567890',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Insert guru
        $this->db->table('guru')->insert($guruData);

        echo "User guru Munawar.S.Pd berhasil ditambahkan!\n";
        echo "Username: munawar\n";
        echo "Password: 1985-03-15\n";
        echo "Role: guru\n";
    }
} 