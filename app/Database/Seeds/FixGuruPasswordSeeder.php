<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FixGuruPasswordSeeder extends Seeder
{
    public function run()
    {
        // Cari user dengan username 'joni haryanto'
        $user = $this->db->table('users')->where('username', 'joni haryanto')->get()->getRowArray();
        
        if (!$user) {
            echo "User 'joni haryanto' tidak ditemukan di tabel users\n";
            return;
        }
        
        // Hash password 'guru123' dengan bcrypt
        $hashedPassword = password_hash('guru123', PASSWORD_BCRYPT);
        
        // Update password di database
        $this->db->table('users')->where('id', $user['id'])->update([
            'password' => $hashedPassword,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        echo "Password untuk user 'joni haryanto' berhasil di-hash\n";
        echo "Username: joni haryanto\n";
        echo "Password: guru123 (sudah di-hash)\n";
        echo "Role: " . $user['role'] . "\n";
    }
} 